<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Stats
        $totalRevenue = OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'delivered');
        })->sum(DB::raw('price * quantity'));

        $totalUsers = User::count();
        $totalOrders = Order::count();
        $totalProducts = Product::count();

        // 2. Recent Orders
        $recentOrders = Order::with('buyer')->latest()->take(5)->get();

        // 3. Monthly Earnings (Last 6 Months)
        $monthlyEarnings = [];
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $months[] = $monthName;

            $earning = OrderItem::whereHas('order', function ($query) use ($date) {
                $query->where('status', 'delivered')
                    ->whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month);
            })->sum(DB::raw('price * quantity'));

            $monthlyEarnings[] = $earning;
        }

        return view('admin.dashboard.index', compact(
            'totalRevenue',
            'totalUsers',
            'totalOrders',
            'totalProducts',
            'recentOrders',
            'monthlyEarnings',
            'months'
        ));
    }
}
