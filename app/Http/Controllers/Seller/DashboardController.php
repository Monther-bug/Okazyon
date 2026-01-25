<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        \Illuminate\Support\Facades\Log::info('DashboardController Auth ID: ' . $user->id);

        // 1. Total Stats
        $totalProducts = $user->products()->where('status', 'approved')->count();

        $totalOrders = \App\Models\Order::whereHas('items.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $totalRevenue = \App\Models\OrderItem::whereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->whereHas('order', function ($query) {
            $query->where('status', 'delivered');
        })->sum(\DB::raw('price * quantity'));

        // 2. Recent Orders
        $recentOrders = \App\Models\Order::whereHas('items.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['buyer'])->latest()->take(5)->get();

        // 3. Status Breakdown
        $pendingOrders = \App\Models\Order::whereHas('items.product', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'pending')->count();

        // 4. Monthly Earnings (Simple Chart Data - Last 6 Months)
        $monthlyEarnings = [];
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $months[] = $monthName;

            $earning = \App\Models\OrderItem::whereHas('product', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->whereHas('order', function ($query) use ($date) {
                $query->where('status', 'delivered')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month);
            })->sum(\DB::raw('price * quantity'));

            $monthlyEarnings[] = $earning;
        }

        return view('seller.dashboard.index', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'recentOrders',
            'pendingOrders',
            'monthlyEarnings',
            'months'
        ));
    }
}
