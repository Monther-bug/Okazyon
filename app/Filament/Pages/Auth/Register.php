<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;

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

    protected function getFormData(): array
    {
        $data = parent::getFormData();
        
        // Make sure phone_number is in the data
        if (isset($data['phone_number'])) {
            $data['phone_number'] = $data['phone_number'];
        }
        
        return $data;
    }
}
