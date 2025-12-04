<?php

namespace App\Filament\Seller\Resources\BannerRequestResource\Pages;

use App\Filament\Seller\Resources\BannerRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBannerRequests extends ListRecords
{
    protected static string $resource = BannerRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
