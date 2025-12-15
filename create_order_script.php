<?php
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;

$sellerId = 2;
$seller = User::find($sellerId);

if (!$seller) {
    echo "User 32 not found!\n";
    exit(1);
}

// Ensure category exists
$cat = Category::firstOrCreate(['name' => 'General'], ['slug' => 'general']);

// Create Product
$product = Product::create([
    'user_id' => $seller->id, // Explicitly set user_id
    'name' => 'Ali Real Test Product',
    'description' => 'Created via script',
    'price' => 250.00,
    'category_id' => $cat->id,
    'status' => 'approved',
    'images' => []
]);

echo "Product Created: {$product->id} - {$product->name}\n";

// Create Order
$order = Order::create([
    'buyer_id' => 1, // Admin user buys
    'total_amount' => 250.00,
    'delivery_address' => 'Tripoli HQ',
    'status' => 'pending'
]);

echo "Order Created: {$order->id}\n";

// Attach Item
OrderItem::create([
    'order_id' => $order->id,
    'product_id' => $product->id,
    'quantity' => 1,
    'price' => 250.00
]);

echo "Order Item Attached. DONE.\n";
