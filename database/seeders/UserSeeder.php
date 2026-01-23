<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');

        // 1. Admin (Phone only)
        $admin = User::firstOrCreate(
            ['phone_number' => '0916880943'],
            [
                'first_name' => 'Monther',
                'last_name' => 'ibrahim',
                'password' => $password,
                'email' => null,
                'role' => 'admin', // Explicitly set role
                'is_verified' => true,
            ]
        );
        $admin->assignRole('admin');

        // 2. Demo Seller
        $demoSeller = User::firstOrCreate(
            ['phone_number' => '0910000000'],
            [
                'first_name' => 'Pro Style',
                'last_name' => 'Boutique',
                'password' => $password,
                'email' => 'seller@okazyon.com',
                'role' => 'seller', // Explicitly set role
                'is_verified' => true,
            ]
        );
        $demoSeller->assignRole('seller');

        // 3. Demo Buyer
        $buyer = User::firstOrCreate(
            ['phone_number' => '0911111111'],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'password' => $password,
                'email' => 'user@okazyon.com',
                'role' => 'buyer', // Explicitly set role (enum is buyer)
                'is_verified' => true,
            ]
        );
        $buyer->assignRole('user'); // Spatie role is 'user'

        // 4. Random Sellers
        User::factory(5)->create(['role' => 'seller'])->each(function ($user) {
            $user->assignRole('seller');
        });

        // 5. Random Buyers
        User::factory(10)->create(['role' => 'buyer'])->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
