<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Set locale to Arabic for faker if needed, 
        // but we are using hardcoded Arabic strings for quality.

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            BannerSeeder::class,
        ]);
    }
}
