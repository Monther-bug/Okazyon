<?php

namespace App\Filament\Pages\Auth;

use App\Services\OTP\OtpService;
use Filament\Notifications\Notification;
use Filament\Pages\SimplePage;
use Illuminate\Support\Facades\Session;

class VerifyOtp extends SimplePage
{
    protected static string $view = 'filament.pages.auth.verify-otp';
    
    protected static ?string $title = 'Verify OTP';
    
    public ?array $data = [];
    
    public ?string $phoneNumber = null;

    public function mount(): void
    {
        $this->phoneNumber = Session::get('otp_phone_number');
        
        if (!$this->phoneNumber) {
            Notification::make()
                ->title('Session Expired')
                ->body('Please start the registration process again.')
                ->warning()
                ->send();
                
            redirect()->to(filament()->getRegistrationUrl());
        }
        
        $this->data = [
            'phone_number' => $this->phoneNumber,
            'otp_code' => '',
        ];
    }

    public function verify(): void
    {
        if (empty($this->data['otp_code']) || strlen($this->data['otp_code']) !== 6) {
            Notification::make()
                ->title('Invalid OTP')
                ->body('Please enter a valid 6-digit OTP code.')
                ->danger()
                ->send();
            return;
        }
        
        $otpService = app(OtpService::class);
        
        if ($otpService->verifyOtp($this->phoneNumber, $this->data['otp_code'])) {
            Session::put('otp_verified', true);
            Session::put('verified_phone_number', $this->phoneNumber);
            
            Notification::make()
                ->title('OTP Verified Successfully!')
                ->body('Your phone number has been verified. Completing your registration...')
                ->success()
                ->send();
            
            // Continue with registration
            $this->completeRegistration();
        } else {
            Notification::make()
                ->title('Invalid OTP')
                ->body('The OTP code you entered is incorrect or has expired. Please try again.')
                ->danger()
                ->duration(5000)
                ->send();
                
            $this->data['otp_code'] = '';
        }
    }

    protected function completeRegistration(): void
    {
        $registrationData = Session::get('registration_data');
        
        if (!$registrationData) {
            Notification::make()
                ->title('Registration Data Missing')
                ->body('Please start the registration process again.')
                ->danger()
                ->send();
                
            redirect()->to(filament()->getRegistrationUrl());
            return;
        }
        
        // Create the user
        $user = \App\Models\User::create([
            'name' => $registrationData['name'],
            'phone_number' => $this->phoneNumber,
            'email' => $registrationData['email'] ?? null,
            'password' => $registrationData['password'],
            'type' => 'seller',
        ]);
        
        // Assign seller role
        $user->assignRole('seller');
        
        // Clear session data
        Session::forget(['otp_phone_number', 'otp_verified', 'verified_phone_number', 'registration_data']);
        
        // Log the user in
        auth()->login($user);
        
        Notification::make()
            ->title('Registration Successful!')
            ->body('Welcome to Okazyon! Your account has been created successfully.')
            ->success()
            ->send();
        
        redirect()->to(filament()->getUrl());
    }

    public function resendOtp(): void
    {
        $otpService = app(OtpService::class);
        
        if ($otpService->generateOtp($this->phoneNumber, 'registration')) {
            Notification::make()
                ->title('OTP Resent')
                ->body('A new OTP code has been sent to your phone number.')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Failed to Resend OTP')
                ->body('There was an error sending the OTP. Please try again later.')
                ->danger()
                ->send();
        }
    }

    public function hasLogo(): bool
    {
        return false;
    }
}
