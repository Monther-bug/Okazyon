<?php
echo "DB Path: " . database_path('database.sqlite') . "\n";
echo "DB Connection: " . config('database.default') . "\n";

$u = App\Models\User::where('phone_number', '0910000000')->first();
if (!$u) {
    die("User not found\n");
}
echo "User: {$u->id}\n";

// Force Create Products
echo "Current Product Count: " . $u->products()->count() . "\n";
$category = \App\Models\Category::firstOrCreate(['name' => 'Electronics']);

for ($i = 1; $i <= 5; $i++) {
    $p = \App\Models\Product::create([
        'user_id' => $u->id,
        'category_id' => $category->id,
        'name' => 'Force Seeded Product ' . $i . ' - ' . uniqid(),
        'description' => 'Test Desc',
        'price' => 100,
        'discounted_price' => 90,
        'status' => 'approved',
        'images' => [],
    ]);
    echo "Created Product ID: {$p->id}\n";
}

// Force Create Order
$buyer = \App\Models\User::where('type', 'buyer')->first() ?? \App\Models\User::factory()->create(['type' => 'buyer', 'phone_number' => '0988888888']);
$order = \App\Models\Order::create([
    'buyer_id' => $buyer->id,
    'total_amount' => 500,
    'status' => 'delivered',
    'delivery_address' => 'Test',
]);
\App\Models\OrderItem::create([
    'order_id' => $order->id,
    'product_id' => $p->id, // Use the last created product
    'quantity' => 5,
    'price' => 100,
]);
echo "Created Order ID: {$order->id} with Item for Product {$p->id}\n";

echo "FINAL CHECK: User Products: " . $u->products()->count() . "\n";
