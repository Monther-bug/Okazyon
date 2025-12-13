<?php
$phone = '0910000000';
$u = App\Models\User::where('phone_number', $phone)->first();

if (!$u) {
    echo "User $phone NOT FOUND.\n";
    exit;
}

echo "User Found: {$u->name} (ID: {$u->id})\n";
echo "------------------------------------------------\n";

// 1. Check Products
$productCount = $u->products()->count();
echo "Products Count: $productCount\n";
if ($productCount > 0) {
    echo "Sample Product: " . $u->products()->first()->name . " (ID: " . $u->products()->first()->id . ")\n";
} else {
    echo "WARNING: No products linked to this user.\n";
}

echo "------------------------------------------------\n";

// 2. Check Orders via Items
$orders = App\Models\Order::whereHas('items.product', function ($q) use ($u) {
    $q->where('user_id', $u->id);
})->get();

echo "Orders Count: " . $orders->count() . "\n";

if ($orders->count() > 0) {
    $o = $orders->first();
    echo "Sample Order ID: {$o->id}, Status: {$o->status}, Created: {$o->created_at}\n";
    echo "Items in this order belonging to seller:\n";
    foreach ($o->items as $item) {
        if ($item->product->user_id == $u->id) {
            echo " - {$item->product->name} (Qty: {$item->quantity})\n";
        }
    }
} else {
    echo "WARNING: No orders found containing products from this seller.\n";

    // Deep dive: Check if ANY orders exist at all?
    echo "Total Orders in DB: " . App\Models\Order::count() . "\n";
    echo "Total OrderItems in DB: " . App\Models\OrderItem::count() . "\n";
}

echo "------------------------------------------------\n";
