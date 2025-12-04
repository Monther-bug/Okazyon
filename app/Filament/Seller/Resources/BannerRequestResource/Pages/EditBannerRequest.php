<?php

namespace App\Filament\Seller\Resources\BannerRequestResource\Pages;

use App\Filament\Seller\Resources\BannerRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBannerRequest extends EditRecord
{
    protected static string $resource = BannerRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
