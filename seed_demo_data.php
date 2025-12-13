<?php

$demoSeller = App\Models\User::where('phone_number', '0910000000')->first();

if (!$demoSeller) {
    echo "Demo seller not found!\n";
    exit;
}

echo "Seeding data for {$demoSeller->name} (ID: {$demoSeller->id})...\n";

// 1. Create Products
if ($demoSeller->products()->count() == 0) {
    echo "Creating Products...\n";
    $category = \App\Models\Category::firstOrCreate(
        ['name' => 'Electronics'],
        ['image' => 'categories/default.png', 'is_active' => true]
    );

    for ($i = 1; $i <= 5; $i++) {
        \App\Models\Product::create([
            'user_id' => $demoSeller->id,
            'category_id' => $category->id,
            'name' => 'Demo Product ' . $i,
            'description' => 'High quality demo product.',
            'price' => rand(100, 500),
            'discounted_price' => rand(50, 99),
            'status' => 'approved',
            'images' => [],
        ]);
    }
}

// 2. Create Orders
echo "Creating Orders...\n";
$products = $demoSeller->products;
$buyer = \App\Models\User::where('type', 'buyer')->first(); // Grab any buyer

if (!$buyer) {
    $buyer = \App\Models\User::factory()->create(['type' => 'buyer', 'phone_number' => '0999999999']);
}

for ($i = 1; $i <= 10; $i++) {
    $order = \App\Models\Order::create([
        'buyer_id' => $buyer->id,
        'total_amount' => 0, // Will calculate
        'status' => collect(['pending', 'processing', 'delivered', 'cancelled'])->random(),
        'delivery_address' => '123 Fake St, Tripoli',
        'created_at' => now()->subDays(rand(0, 30)),
    ]);

    $total = 0;
    // Add 1-3 random products from this seller
    foreach ($products->random(rand(1, 3)) as $product) {
        $qty = rand(1, 2);
        \App\Models\OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $qty,
            'price' => $product->price,
        ]);
        $total += ($product->price * $qty);
    }

    $order->update(['total_amount' => $total]);
}

echo "Done! Created products and orders for Demo Seller.\n";
