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
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            BannerSeeder::class,
            ProductSeeder::class,
            NotificationSeeder::class,
            FcmTokenSeeder::class,
        ]);

        $this->command->info('🎉 Database seeding completed successfully!');

    }
}
