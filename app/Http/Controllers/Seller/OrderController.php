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
    public function index()
    {
        $sellerId = Auth::id();

        // Fetch orders that contain products from this seller
        $orders = Order::whereHas('items.product', function ($query) use ($sellerId) {
            $query->where('user_id', $sellerId);
        })->with(['buyer'])->latest()->paginate(10);

        return view('seller.orders.index', compact('orders'));
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

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
