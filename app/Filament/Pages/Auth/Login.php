<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Notifications\Notification;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('phone_number')
            ->label('Phone Number')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->placeholder('Enter your phone number')
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'phone_number' => $data['phone_number'],
            'password' => $data['password'],
        ];
    }

    protected function throwFailureValidationException(): never
    {
        Notification::make()
            ->title('Login Failed')
            ->body('The phone number or password you entered is incorrect. Please try again.')
            ->danger()
            ->duration(5000)
            ->send();

        throw ValidationException::withMessages([
            'data.phone_number' => __('filament-panels::pages/auth/login.messages.failed'),
        ]);
    }

    public function authenticate(): ?LoginResponse
    {
        $response = parent::authenticate();

        if ($response) {
            Notification::make()
                ->title('Welcome Back!')
                ->body('You have successfully logged in.')
                ->success()
                ->duration(3000)
                ->send();
        }

        return $response;
    }
}
