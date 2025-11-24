<?php

namespace App\Filament\Seller\Widgets;

use App\Models\Order;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $sellerId = auth()->id();
        
        // Calculate total revenue from delivered orders containing seller's products
        $totalRevenue = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.user_id', $sellerId)
            ->where('orders.status', 'delivered')
            ->sum(DB::raw('order_items.price * order_items.quantity'));
        
        // Count new orders (pending) containing seller's products
        $newOrders = Order::where('status', 'pending')
            ->whereHas('items.product', function ($query) use ($sellerId) {
                $query->where('user_id', $sellerId);
            })
            ->count();
        
        // Count total products for this seller
        $totalProducts = Product::where('user_id', $sellerId)->count();
        
        // Count approved products
        $approvedProducts = Product::where('user_id', $sellerId)
            ->where('status', 'approved')
            ->count();
        
        return [
            Stat::make('Total Revenue', '$' . number_format($totalRevenue, 2))
                ->description('From delivered orders')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->chart([7, 3, 4, 5, 6, 3, 5, 3]),
            
            Stat::make('New Orders', $newOrders)
                ->description('Pending orders to process')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning')
                ->chart([3, 2, 4, 3, 5, 4, 6, 5]),
            
            Stat::make('Total Products', $totalProducts)
                ->description($approvedProducts . ' approved, ' . ($totalProducts - $approvedProducts) . ' pending')
                ->descriptionIcon('heroicon-m-cube')
                ->color('info')
                ->chart([1, 2, 2, 3, 3, 4, 4, 5]),
        ];
    }
}
