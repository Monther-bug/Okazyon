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
                'name' => 'سلع استهلاكية',
                'slug' => 'consumer-goods',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=800',
                'type' => 'goods',
            ],
            [
                'name' => 'مأكولات ومشروبات',
                'slug' => 'food-beverages',
                'image' => 'https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=800',
                'type' => 'food',
            ],
            [
                'name' => 'أزياء وموضة',
                'slug' => 'fashion',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b830c6050?q=80&w=800',
                'type' => 'clothes',
            ],
            [
                'name' => 'إلكترونيات وهواتف',
                'slug' => 'electronics',
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=800',
                'type' => 'goods',
            ],
            [
                'name' => 'أجهزة منزلية',
                'slug' => 'home-appliances',
                'image' => 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=800',
                'type' => 'goods',
            ],
            [
                'name' => 'صحة وجمال',
                'slug' => 'health-beauty',
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?q=80&w=800',
                'type' => 'goods',
            ],
            [
                'name' => 'أثاث وديكور',
                'slug' => 'furniture',
                'image' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=800',
                'type' => 'goods',
            ],
            [
                'name' => 'رياضة ولياقة',
                'slug' => 'sports',
                'image' => 'https://images.unsplash.com/photo-1461896704690-264ad730d4aa?q=80&w=800',
                'type' => 'goods',
            ],
            [
                'name' => 'ألعاب وأطفال',
                'slug' => 'toys-kids',
                'image' => 'https://images.unsplash.com/photo-1533512930330-4ac257c86793?q=80&w=800',
                'type' => 'goods',
            ],
            [
                'name' => 'سيارات ومحركات',
                'slug' => 'automotive',
                'image' => 'https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?q=80&w=800',
                'type' => 'goods',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'image' => $category['image'],
                    'type' => $category['type'],
                    'is_active' => true,
                ]
            );
        }
    }
}
