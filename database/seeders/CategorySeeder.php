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
                'name' => 'Electronics',
                'type' => 'goods',
                'is_active' => true,
            ],
            [
                'name' => 'Clothing & Fashion',
                'type' => 'goods',
                'is_active' => true,
            ],
            [
                'name' => 'Home & Garden',
                'type' => 'goods',
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
