<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerRequestResource\Pages;
use App\Filament\Resources\BannerRequestResource\RelationManagers;
use App\Models\BannerRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerRequestResource extends Resource
{
    protected static ?string $model = BannerRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled(),
                Forms\Components\TextInput::make('title')
                    ->disabled(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->disabled(),
                Forms\Components\TextInput::make('link')
                    ->disabled(),
                Forms\Components\TextInput::make('status')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Seller')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->width(200)
                    ->height(100),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'pending' => 'warning',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->action(function (BannerRequest $record) {
                        $record->update(['status' => 'approved']);

                        // Create the actual Banner
                        \App\Models\Banner::create([
                            'title' => $record->title,
                            'image' => $record->image,
                            'link' => $record->link,
                            'is_active' => true,
                        ]);
                    })
                    ->requiresConfirmation()
                    ->color('success')
                    ->icon('heroicon-o-check')
                    ->visible(fn(BannerRequest $record) => $record->status === 'pending'),
                Tables\Actions\Action::make('reject')
                    ->action(fn(BannerRequest $record) => $record->update(['status' => 'rejected']))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->icon('heroicon-o-x-mark')
                    ->visible(fn(BannerRequest $record) => $record->status === 'pending'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListBannerRequests::route('/'),
            'create' => Pages\CreateBannerRequest::route('/create'),
            'edit' => Pages\EditBannerRequest::route('/{record}/edit'),
        ];
    }
}
