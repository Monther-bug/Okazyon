<?php

namespace App\Filament\Seller\Pages\Auth;

use App\Models\User;
use App\Services\OTP\OtpService;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;

class SellerRegister extends BaseRegister
{
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        $this->getFirstNameFormComponent(),
                        $this->getLastNameFormComponent(),
                        $this->getPhoneNumberFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function getFirstNameFormComponent(): Component
    {
        return TextInput::make('first_name')
            ->label('First Name')
            ->required()
            ->maxLength(255);
    }

    protected function getLastNameFormComponent(): Component
    {
        return TextInput::make('last_name')
            ->label('Last Name')
            ->required()
            ->maxLength(255);
    }

    protected function getPhoneNumberFormComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label('Phone Number')
            ->required()
            ->unique(User::class, 'phone_number')
            ->tel()
            ->placeholder('09XXXXXXXXX');
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->label('Password')
            ->password()
            ->required()
            ->minLength(8);
    }

    protected function getPasswordConfirmationFormComponent(): Component
    {
        return TextInput::make('password_confirmation')
            ->label('Confirm Password')
            ->password()
            ->required()
            ->same('password');
    }

    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();

        // Store registration data in session
        session([
            'registration_data' => [
                'name' => $data['first_name'] . ' ' . $data['last_name'], // VerifyOtp expects 'name'
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'phone_number' => $data['phone_number'],
                'password' => Hash::make($data['password']),
                'type' => 'seller',
            ]
        ]);

        // Send OTP
        $otpService = app(OtpService::class);
        $otpService->send($data['phone_number']);

        // Store phone number for verification page
        session(['otp_phone_number' => $data['phone_number']]);

        Notification::make()
            ->title('OTP Sent')
            ->body('Please check your phone for the verification code.')
            ->success()
            ->send();

        // Redirect to OTP verification page
        redirect()->route('filament.seller.auth.verify-otp');

        return null;
    }
}
