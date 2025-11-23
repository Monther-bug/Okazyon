<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Notifications\Notification;

class ViewProduct extends ViewRecord
{
    protected static string $resource = ProductResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            
            Actions\Action::make('approve')
                ->label('Approve Product')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn () => $this->record->status !== 'approved')
                ->requiresConfirmation()
                ->modalHeading('Approve Product')
                ->modalDescription('Are you sure you want to approve this product? It will be visible to all buyers.')
                ->modalSubmitActionLabel('Yes, Approve')
                ->action(function () {
                    $this->record->update(['status' => 'approved']);
                    
                    Notification::make()
                        ->success()
                        ->title('Product Approved')
                        ->body("'{$this->record->name}' has been approved and is now live.")
                        ->send();
                }),
            
            Actions\Action::make('reject')
                ->label('Reject Product')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->visible(fn () => $this->record->status !== 'rejected')
                ->requiresConfirmation()
                ->modalHeading('Reject Product')
                ->modalDescription('Are you sure you want to reject this product? The seller will be notified.')
                ->modalSubmitActionLabel('Yes, Reject')
                ->action(function () {
                    $this->record->update(['status' => 'rejected']);
                    
                    Notification::make()
                        ->warning()
                        ->title('Product Rejected')
                        ->body("'{$this->record->name}' has been rejected.")
                        ->send();
                }),
            
            Actions\DeleteAction::make(),
        ];
    }
}
