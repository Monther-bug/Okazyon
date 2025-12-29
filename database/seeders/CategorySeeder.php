<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Food categories
            [
                'name' => 'Fresh Produce',
                'type' => 'food',
                'image' => 'https://picsum.photos/400/400?random=101',
                'is_active' => true,
            ],
            [
                'name' => 'Dairy Products',
                'type' => 'food',
                'image' => 'https://picsum.photos/400/400?random=102',
                'is_active' => true,
            ],
            [
                'name' => 'Fast Food',
                'type' => 'food',
                'image' => 'https://picsum.photos/400/400?random=103',
                'is_active' => true,
            ],
            // Clothing categories
            [
                'name' => 'Men\'s Fashion',
                'type' => 'clothes',
                'image' => 'https://picsum.photos/400/400?random=104',
                'is_active' => true,
            ],
            [
                'name' => 'Women\'s Fashion',
                'type' => 'clothes',
                'image' => 'https://picsum.photos/400/400?random=105',
                'is_active' => true,
            ],
            [
                'name' => 'Kids\' Wear',
                'type' => 'clothes',
                'image' => 'https://picsum.photos/400/400?random=106',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        $this->command->info('✅ Created ' . count($categories) . ' categories with images');
    }
}
