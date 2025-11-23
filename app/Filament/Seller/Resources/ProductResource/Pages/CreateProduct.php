<?php

namespace App\Filament\Seller\Resources\ProductResource\Pages;

use App\Filament\Seller\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
    
    /**
     * Mutate form data before creating the product
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Get the actual user ID (not phone number)
        $user = auth()->user();
        $data['user_id'] = $user->id; // Use the actual ID column
        
        // Force status to pending for admin approval
        $data['status'] = 'pending';
        
        return $data;
    }
    
    /**
     * Get the redirect URL after creating
     */
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    /**
     * Send notification after creating
     */
    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Product created successfully')
            ->body('Your product has been submitted for approval. You will be notified once it is reviewed.');
    }
}
