<?php

namespace App\Filament\Seller\Auth;

use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')
                    ->label('First Name')
                    ->required()
                    ->maxLength(255)
                    ->autofocus(),
                TextInput::make('last_name')
                    ->label('Last Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone_number')
                    ->label('Phone Number')
                    ->tel()
                    ->required()
                    ->unique(User::class)
                    ->maxLength(255)
                    ->placeholder('Enter your phone number'),
                TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->confirmed()
                    ->minLength(8)
                    ->maxLength(255),
                TextInput::make('password_confirmation')
                    ->label('Confirm Password')
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    protected function handleRegistration(array $data): User
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'role' => 'seller', // Automatically assign seller role
            'is_verified' => false,
            'status' => 'active',
        ]);
    }
}
