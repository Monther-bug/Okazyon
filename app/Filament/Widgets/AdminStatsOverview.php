<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Revenue', '$' . number_format(\App\Models\Order::where('status', 'delivered')->sum('total_amount'), 2)),
            Stat::make('Pending Products', \App\Models\Product::where('status', 'pending')->count())
                ->description('Products awaiting approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
            Stat::make('Total Sellers', \App\Models\User::where('type', 'seller')->count())
                ->description('Registered sellers')
                ->descriptionIcon('heroicon-m-users')
                ->color('success'),
        ];
    }
}
