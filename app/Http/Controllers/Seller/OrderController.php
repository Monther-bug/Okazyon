<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sellerId = Auth::id();
        $query = Order::whereHas('items.product', function ($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })->with(['buyer', 'items.product']);

        // Search by Order ID or Buyer Name
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                    ->orWhereHas('buyer', function ($bq) use ($searchTerm) {
                        $bq->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }

        // Filter by Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('seller.orders.index', compact('orders'));
    }

    public function export(Request $request)
    {
        $sellerId = Auth::id();
        $query = Order::whereHas('items.product', function ($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })->with(['buyer']);

        // Apply same filters for export
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                    ->orWhereHas('buyer', function ($bq) use ($searchTerm) {
                        $bq->where('name', 'like', "%{$searchTerm}%");
                    });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        $filename = "orders_export_" . date('Y-m-d') . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Order ID', 'Buyer', 'Total Amount', 'Status', 'Date'];

        $callback = function () use ($orders, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->buyer->name ?? 'Guest User',
                    $order->total_amount,
                    $order->status,
                    $order->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $sellerId = Auth::id();

        // Ensure the order belongs to this seller (has items from them)
        $hasItems = $order->items()->whereHas('product', function ($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })->exists();

        if (!$hasItems) {
            abort(403);
        }

        // Get only the items for this seller
        $sellerItems = $order->items()->whereHas('product', function ($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })->with('product')->get();

        return view('seller.orders.show', compact('order', 'sellerItems'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $sellerId = Auth::id();

        // Ensure the order belongs to this seller
        $hasItems = $order->items()->whereHas('product', function ($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })->exists();

        if (!$hasItems) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,processing,delivered,cancelled',
        ]);

        $order->update(['status' => $validated['status']]);

        // Notify Buyer
        app(\App\Services\Firebase\NotificationService::class)->notifyOrderStatusUpdate($order);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
