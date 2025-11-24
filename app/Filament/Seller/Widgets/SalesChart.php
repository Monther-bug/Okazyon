<?php

namespace App\Filament\Seller\Widgets;

use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Sales Revenue';
    
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';
    
    public ?string $filter = 'year';

    protected function getData(): array
    {
        $sellerId = auth()->id();
        $now = now();
        
        // Determine the date range based on filter
        $startDate = match ($this->filter) {
            'today' => $now->copy()->startOfDay(),
            'week' => $now->copy()->startOfWeek(),
            'month' => $now->copy()->startOfMonth(),
            'year' => $now->copy()->startOfYear(),
            default => $now->copy()->startOfYear(),
        };
        
        // Get the grouping format based on filter
        [$groupBy, $labelFormat, $labels] = match ($this->filter) {
            'today' => ['hour', 'H:00', $this->generateHourlyLabels()],
            'week' => ['date', 'M d', $this->generateDailyLabels($startDate, 7)],
            'month' => ['date', 'M d', $this->generateDailyLabels($startDate, $now->daysInMonth)],
            'year' => ['month', 'M', $this->generateMonthlyLabels()],
            default => ['month', 'M', $this->generateMonthlyLabels()],
        };
        
        // Query sales data
        if ($groupBy === 'hour') {
            $salesData = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.user_id', $sellerId)
                ->where('orders.status', 'delivered')
                ->where('orders.created_at', '>=', $startDate)
                ->select(
                    DB::raw("CAST(strftime('%H', orders.created_at) AS INTEGER) as period"),
                    DB::raw('SUM(order_items.price * order_items.quantity) as total')
                )
                ->groupBy('period')
                ->pluck('total', 'period');
        } elseif ($groupBy === 'date') {
            $salesData = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.user_id', $sellerId)
                ->where('orders.status', 'delivered')
                ->where('orders.created_at', '>=', $startDate)
                ->select(
                    DB::raw("DATE(orders.created_at) as period"),
                    DB::raw('SUM(order_items.price * order_items.quantity) as total')
                )
                ->groupBy('period')
                ->pluck('total', 'period');
        } else { // month
            $salesData = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('products.user_id', $sellerId)
                ->where('orders.status', 'delivered')
                ->where('orders.created_at', '>=', $startDate)
                ->select(
                    DB::raw("CAST(strftime('%m', orders.created_at) AS INTEGER) as period"),
                    DB::raw('SUM(order_items.price * order_items.quantity) as total')
                )
                ->groupBy('period')
                ->pluck('total', 'period');
        }
        
        $data = [];
        foreach ($labels as $index => $label) {
            if ($groupBy === 'hour') {
                $data[] = $salesData[$index] ?? 0;
            } elseif ($groupBy === 'date') {
                $date = $startDate->copy()->addDays($index)->format('Y-m-d');
                $data[] = $salesData[$date] ?? 0;
            } else { // month
                $data[] = $salesData[$index + 1] ?? 0; // Months are 1-indexed
            }
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Revenue',
                    'data' => $data,
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#059669',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
    
    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'This Week',
            'month' => 'This Month',
            'year' => 'This Year',
        ];
    }
    
    protected function generateHourlyLabels(): array
    {
        $labels = [];
        for ($i = 0; $i < 24; $i++) {
            $labels[] = sprintf('%02d:00', $i);
        }
        return $labels;
    }
    
    protected function generateDailyLabels(Carbon $startDate, int $days): array
    {
        $labels = [];
        for ($i = 0; $i < $days; $i++) {
            $labels[] = $startDate->copy()->addDays($i)->format('M d');
        }
        return $labels;
    }
    
    protected function generateMonthlyLabels(): array
    {
        return ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    }
}
