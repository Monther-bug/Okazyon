<?php

namespace App\Filament\Seller\Resources\OrderResource\Pages;

use App\Filament\Seller\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Notifications\Notification;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('updateStatus')
                ->label('Update Status')
                ->icon('heroicon-o-truck')
                ->color('primary')
                ->form([
                    Forms\Components\Select::make('status')
                        ->label('Order Status')
                        ->options([
                            'pending' => 'Pending',
                            'processing' => 'Processing',
                            'delivered' => 'Delivered',
                            'cancelled' => 'Cancelled',
                        ])
                        ->required()
                        ->default(fn () => $this->record->status),
                ])
                ->action(function (array $data): void {
                    $this->record->update(['status' => $data['status']]);
                    
                    Notification::make()
                        ->success()
                        ->title('Status Updated')
                        ->body("Order #{$this->record->id} status has been updated to {$data['status']}.")
                        ->send();
                }),
        ];
    }
}
