<?php

namespace App\Filament\Seller\Resources;

use App\Filament\Seller\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    
    protected static ?int $navigationSort = 3;

    /**
     * Scope to show only orders that contain products from the logged-in seller
     */
    public static function getEloquentQuery(): Builder
    {
        $userId = auth()->user()->id;
        
        return parent::getEloquentQuery()
            ->whereHas('items.product', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with(['buyer', 'items.product']);
    }

    public static function form(Form $form): Form
    {
        // Sellers cannot create/edit orders directly
        return $form
            ->schema([
                Forms\Components\Placeholder::make('info')
                    ->label('')
                    ->content('Orders cannot be created or edited directly. They are created when customers make purchases.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('Order ID')
                    ->searchable()
                    ->sortable()
                    ->prefix('#'),
                
                Tables\Columns\TextColumn::make('buyer.name')
                    ->label('Buyer Name')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Amount')
                    ->money('USD')
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'processing',
                        'success' => 'delivered',
                        'danger' => 'cancelled',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-arrow-path' => 'processing',
                        'heroicon-o-check-circle' => 'delivered',
                        'heroicon-o-x-circle' => 'cancelled',
                    ]),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'delivered' => 'Delivered',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                
                Tables\Actions\Action::make('updateStatus')
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
                            ->default(fn ($record) => $record->status),
                    ])
                    ->action(function (Order $record, array $data): void {
                        $record->update(['status' => $data['status']]);
                        
                        Notification::make()
                            ->success()
                            ->title('Status Updated')
                            ->body("Order #{$record->id} status has been updated to {$data['status']}.")
                            ->send();
                    }),
            ])
            ->bulkActions([
                // No bulk actions - sellers shouldn't delete orders
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Order Details')
                    ->schema([
                        Infolists\Components\TextEntry::make('id')
                            ->label('Order ID')
                            ->prefix('#'),
                        
                        Infolists\Components\TextEntry::make('buyer.name')
                            ->label('Buyer Name'),
                        
                        Infolists\Components\TextEntry::make('buyer.phone_number')
                            ->label('Buyer Phone'),
                        
                        Infolists\Components\TextEntry::make('delivery_address')
                            ->label('Delivery Address')
                            ->columnSpan(2),
                        
                        Infolists\Components\TextEntry::make('total_amount')
                            ->label('Total Amount')
                            ->money('USD'),
                        
                        Infolists\Components\TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'processing' => 'info',
                                'delivered' => 'success',
                                'cancelled' => 'danger',
                                default => 'gray',
                            }),
                        
                        Infolists\Components\TextEntry::make('created_at')
                            ->label('Order Date')
                            ->dateTime(),
                    ])
                    ->columns(2),
                
                Infolists\Components\Section::make('Your Products in this Order')
                    ->description('These are only your products from this order')
                    ->schema([
                        Infolists\Components\RepeatableEntry::make('items')
                            ->label('')
                            ->schema([
                                Infolists\Components\TextEntry::make('product.name')
                                    ->label('Product'),
                                
                                Infolists\Components\TextEntry::make('quantity')
                                    ->label('Quantity'),
                                
                                Infolists\Components\TextEntry::make('price')
                                    ->label('Price')
                                    ->money('USD'),
                                
                                Infolists\Components\TextEntry::make('subtotal')
                                    ->label('Subtotal')
                                    ->state(fn ($record) => $record->quantity * $record->price)
                                    ->money('USD'),
                            ])
                            ->columns(4)
                            ->getStateUsing(function ($record) {
                                // Filter to show only this seller's products
                                $userId = auth()->user()->id;
                                return $record->items()
                                    ->whereHas('product', function ($query) use ($userId) {
                                        $query->where('user_id', $userId);
                                    })
                                    ->get();
                            }),
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
    
    public static function canCreate(): bool
    {
        return false; // Sellers cannot create orders
    }
}
