<?php

namespace Database\Seeders;

use App\Models\User;
use App\Utility\Enums\UserStatusEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Specific Demo Accounts

        // Admin
        $admin = User::create([
            'first_name' => 'منذر',
            'last_name' => '',
            'email' => 'admin@okazyon.com',
            'phone_number' => '0916880943',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'status' => UserStatusEnum::ACTIVE,
            'is_verified' => true,
        ]);
        $admin->assignRole('admin');

        // Main Demo Seller
        $seller = User::create([
            'first_name' => 'منذر',
            'last_name' => 'بوتيك',
            'email' => 'seller@okazyon.com',
            'phone_number' => '0913519105',
            'password' => Hash::make('password'),
            'type' => 'seller',
            'status' => UserStatusEnum::ACTIVE,
            'is_verified' => true,
        ]);
        $seller->assignRole('seller');

        // Main Demo Buyer
        $buyer = User::create([
            'first_name' => 'أحمد',
            'last_name' => 'علي',
            'email' => 'user@okazyon.com',
            'phone_number' => '+201000000003',
            'password' => Hash::make('password'),
            'type' => 'user',
            'status' => UserStatusEnum::ACTIVE,
            'is_verified' => true,
        ]);
        $buyer->assignRole('user');

        // 2. Extra Random Accounts

        // 5 Extra Sellers
        User::factory(5)->active()->create([
            'type' => 'seller',
        ])->each(function ($user) {
            $user->assignRole('seller');
        });

        // 10 Extra Buyers
        User::factory(10)->active()->create([
            'type' => 'user',
        ])->each(function ($user) {
            $user->assignRole('user');
        });
    }
}
