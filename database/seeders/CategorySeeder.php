<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'سلع',
                'slug' => 'goods',
                'image' => 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?q=80&w=800',
                'type' => 'goods',
            ],
            [
                'name' => 'مأكولات',
                'slug' => 'food',
                'image' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=800',
                'type' => 'food',
            ],
            [
                'name' => 'أزياء',
                'slug' => 'fashion',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b830c6050?q=80&w=800',
                'type' => 'clothes',
            ],
            [
                'name' => 'ملابس',
                'slug' => 'clothes',
                'image' => 'https://images.unsplash.com/photo-1489987707025-afc232f7ea0f?q=80&w=800',
                'type' => 'clothes',
            ],
            [
                'name' => 'أحذية',
                'slug' => 'shoes',
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ab?q=80&w=800',
                'type' => 'clothes',
            ],
            [
                'name' => 'اكسسوارات',
                'slug' => 'accessories',
                'image' => 'https://images.unsplash.com/photo-1588444650733-d3423b37b72d?q=80&w=800',
                'type' => 'clothes',
            ],
            [
                'name' => 'أثاث',
                'slug' => 'furniture',
                'image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=800',
                'type' => 'goods',
            ],
            [
                'name' => 'مأكولات ومطاعم',
                'slug' => 'food-dining',
                'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=800',
                'type' => 'food',
            ],
            [
                'name' => 'رياضة',
                'slug' => 'sports',
                'image' => 'https://images.unsplash.com/photo-1461896704690-264ad730d4aa?q=80&w=800',
                'type' => 'goods',
            ],
            [
                'name' => 'كتب',
                'slug' => 'books',
                'image' => 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?q=80&w=800',
                'type' => 'goods',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => $category['slug'],
                'image' => $category['image'],
                'type' => $category['type'],
                'is_active' => true,
            ]);
        }
    }
}
