<?php

namespace App\Filament\Resources\BannerRequestResource\Pages;

use App\Filament\Resources\BannerRequestResource;
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
