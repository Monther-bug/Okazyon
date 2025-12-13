<?php
echo "DB Config: " . config('database.default') . "\n";
echo "DB Name: " . \DB::connection()->getDatabaseName() . "\n";
echo "Total Users: " . App\Models\User::count() . "\n";

echo "Checking User 39...\n";
$u39 = App\Models\User::find(39);
if ($u39) {
    echo "Found ID 39: {$u39->name} ({$u39->phone_number})\n";
} else {
    echo "ID 39 NOT FOUND.\n";
}

$demo = App\Models\User::where('phone_number', '0910000000')->first();
if ($demo) {
    echo "Found by phone 0910000000: {$demo->name} (ID: {$demo->id})\n";
} else {
    echo "Phone 0910000000 NOT FOUND.\n";
}

// Re-create if missing
if (!$demo && !$u39) {
    echo "Recreating Demo Seller...\n";
    $demo = App\Models\User::create([
        'first_name' => 'Demo',
        'last_name' => 'Seller',
        'phone_number' => '0910000000',
        'password' => bcrypt('password'),
        'type' => 'seller',
        'status' => 'active',
        'is_verified' => true,
    ]);
    echo "Created with ID: " . $demo->id . "\n";
} else {
    $demo = $demo ?? $u39;
}

// Fix Permissions
$role = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'seller', 'guard_name' => 'web']);
if (!$demo->hasRole('seller')) {
    $demo->assignRole($role);
    echo "Role 'seller' assigned.\n";
} else {
    echo "Role 'seller' already assigned.\n";
}
