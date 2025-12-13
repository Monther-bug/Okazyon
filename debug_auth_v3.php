<?php
echo "Current User (Auth): " . (auth()->check() ? auth()->id() . " - " . auth()->user()->name : "Guest") . "\n";
$demo = App\Models\User::where('phone_number', '0910000000')->first();
if ($demo) {
    echo "Demo User (DB): ID {$demo->id}, Name: {$demo->name}\n";
    echo " - Products: " . $demo->products()->count() . "\n";
    echo " - Orders (via items): " . App\Models\Order::whereHas('items.product', function ($q) use ($demo) {
        $q->where('user_id', $demo->id);
    })->count() . "\n";
} else {
    echo "Demo User NOT FOUND in DB.\n";
}
