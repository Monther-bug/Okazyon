<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fresh Produce',
                'type' => 'food',
                'is_active' => true,
            ],
            [
                'name' => 'Dairy Products',
                'type' => 'food',
                'is_active' => true,
            ],
            [
                'name' => 'Fast Food',
                'type' => 'food',
                'is_active' => true,
            ],
            [
                'name' => 'Men\'s Fashion',
                'type' => 'clothes',
                'is_active' => true,
            ],
            [
                'name' => 'Women\'s Fashion',
                'type' => 'clothes',
                'is_active' => true,
            ],
            [
                'name' => 'Kids\' Wear',
                'type' => 'clothes',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::firstOrCreate(
                ['name' => $categoryData['name']],
                $categoryData
            );
        }
    }
}
