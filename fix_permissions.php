<?php
echo "Searching for 0910000000...\n";
$user = App\Models\User::where('phone_number', '0910000000')->first();

if (!$user) {
    echo "Phone search failed. Listing recent users:\n";
    foreach (App\Models\User::latest()->take(10)->get() as $u) {
        echo "[ID: {$u->id}] {$u->name} - {$u->phone_number} (Type: {$u->type})\n";
    }

    echo "Attempting to find 'Demo Seller' by name...\n";
    $user = App\Models\User::where('first_name', 'Demo')->where('last_name', 'Seller')->first();
}

if (!$user) {
    echo "CRITICAL: Demo Seller not found.\n";
    exit;
}

echo "Target User: [ID: {$user->id}] {$user->name} ({$user->phone_number})\n";

// Clear cache
app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
echo "Cache Cleared.\n";

// Ensure role exists explicitly for 'web' guard
$role = Spatie\Permission\Models\Role::firstOrCreate(['name' => 'seller', 'guard_name' => 'web']);
echo "Role 'seller' (web) ensured (ID: " . $role->id . ")\n";

// Assign role
if (!$user->hasRole('seller')) {
    $user->assignRole($role);
    echo "Role Assigned.\n";
} else {
    echo "Role already assigned.\n";
}

// Verify
$hasRole = $user->hasRole('seller');
echo "Final Check - hasRole('seller'): " . ($hasRole ? "YES" : "NO") . "\n";
