<?php

namespace App\Filament\Pages\Auth;

use App\Services\OTP\OtpService;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Support\Facades\Session;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;

class Register extends BaseRegister
{
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label('Phone Number')
            ->required()
            ->maxLength(255)
            ->autocomplete()
            ->placeholder('Enter your phone number')
            ->unique($this->getUserModel());
    }

    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();
        
        // Store registration data in session
        Session::put('registration_data', [
            'name' => $data['name'],
            'phone_number' => $data['phone_number'],
            'email' => $data['email'] ?? null,
            'password' => $data['password'],
        ]);
        
        Session::put('otp_phone_number', $data['phone_number']);
        
        // Send OTP
        $otpService = app(OtpService::class);
        
        if ($otpService->generateOtp($data['phone_number'], 'registration')) {
            Notification::make()
                ->title('OTP Sent!')
                ->body('A verification code has been sent to your phone number.')
                ->success()
                ->send();
            
            // Redirect to OTP verification page
            redirect()->route('filament.seller.auth.verify-otp');
            return null;
        } else {
            Notification::make()
                ->title('Failed to Send OTP')
                ->body('There was an error sending the verification code. Please try again.')
                ->danger()
                ->send();
            
            return null;
        }
    }
}
