<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Status')
                    ->description('Control the product approval status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Approval Status')
                            ->options([
                                'pending' => 'Pending Review',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->required()
                            ->default('pending')
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Product Information')
                    ->description('Details submitted by the seller')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Product Name')
                            ->required()
                            ->maxLength(255)
                            ->readOnly(),

                        Forms\Components\Select::make('category_id')
                            ->label('Category')
                            ->relationship('category', 'name')
                            ->required()
                            ->disabled(),

                        Forms\Components\RichEditor::make('description')
                            ->label('Description')
                            ->required()
                            ->columnSpan(2)
                            ->disabled(),

                        Forms\Components\TextInput::make('price')
                            ->label('Regular Price')
                            ->required()
                            ->numeric()
                            ->prefix('$')
                            ->readOnly(),

                        Forms\Components\TextInput::make('discounted_price')
                            ->label('Discounted Price')
                            ->numeric()
                            ->prefix('$')
                            ->readOnly(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Product Images')
                    ->schema([
                        Forms\Components\FileUpload::make('images')
                            ->label('Product Images')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->disabled()
                            ->columnSpan(2),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Seller Information')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Seller')
                            ->relationship('user', 'first_name')
                            ->required()
                            ->disabled()
                            ->columnSpan(2),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('Image')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png'))
                    ->getStateUsing(function ($record) {
                        $images = $record->images;
                        if (is_array($images) && count($images) > 0) {
                            return $images[0];
                        }
                        return null;
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Product Name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Seller')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('USD')
                    ->sortable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'pending' => 'heroicon-o-clock',
                        'approved' => 'heroicon-o-check-circle',
                        'rejected' => 'heroicon-o-x-circle',
                        default => 'heroicon-o-question-mark-circle',
                    })
                    ->formatStateUsing(fn(string $state): string => ucfirst($state)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Approval Status')
                    ->options([
                        'pending' => 'Pending Review',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->default('pending'),

                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->label('Category'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),

                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->visible(fn($record) => $record->status !== 'approved')
                    ->requiresConfirmation()
                    ->action(function (Product $record) {
                        $record->update(['status' => 'approved']);

                        Notification::make()
                            ->success()
                            ->title('Product Approved')
                            ->body("'{$record->name}' has been approved and is now live.")
                            ->send();
                    }),

                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn($record) => $record->status !== 'rejected')
                    ->requiresConfirmation()
                    ->action(function (Product $record) {
                        $record->update(['status' => 'rejected']);

                        Notification::make()
                            ->warning()
                            ->title('Product Rejected')
                            ->body("'{$record->name}' has been rejected.")
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->label('Approve Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            $count = $records->count();
                            $records->each->update(['status' => 'approved']);

                            Notification::make()
                                ->success()
                                ->title('Products Approved')
                                ->body("{$count} product(s) have been approved.")
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('reject')
                        ->label('Reject Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion()
                        ->action(function (Collection $records) {
                            $count = $records->count();
                            $records->each->update(['status' => 'rejected']);

                            Notification::make()
                                ->warning()
                                ->title('Products Rejected')
                                ->body("{$count} product(s) have been rejected.")
                                ->send();
                        }),

                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count() ?: null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }
}
