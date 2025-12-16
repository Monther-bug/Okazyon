<?php

namespace Database\Seeders;

use App\Models\User;
use App\Utility\Enums\UserStatusEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Monther',
            'phone_number' => '0916880943',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'password' => Hash::make('password'),
            'type' => 'admin',
            'status' => UserStatusEnum::ACTIVE,
        ]);

        // Create Seller User
        $seller = User::create([
            'first_name' => 'Monther',
            'last_name' => 'User',
            'phone_number' => '0913519105',
            'date_of_birth' => '1992-05-15',
            'gender' => 'male',
            'password' => Hash::make('password'),
            'type' => 'seller',
            'status' => UserStatusEnum::ACTIVE,
        ]);

        $this->command->info('Created users:');
        $this->command->info('- Admin: 0916880943 / password: password');
        $this->command->info('- Seller: 0913519105 / password: password');
        $this->command->info('Total: ' . User::count() . ' users');
    }
}
