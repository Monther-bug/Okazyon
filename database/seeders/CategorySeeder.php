<?php

namespace Database\Seeders;

use App\Models\Category;
use Database\Seeders\Traits\HasSeedImages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    use HasSeedImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fashion',
                'type' => 'goods',
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Furniture',
                'type' => 'goods',
                'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Food & Dining',
                'type' => 'food',
                'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Sports',
                'type' => 'goods',
                'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&q=80&w=800',
            ],
            [
                'name' => 'Books',
                'type' => 'goods',
                'image' => 'https://images.unsplash.com/photo-1495446815901-a7297e633e8d?auto=format&fit=crop&q=80&w=800',
            ],
        ];

        foreach ($categories as $cat) {
            // Cache locally
            $this->getLocalImage($cat['image']);

            Category::updateOrCreate(
                ['name' => $cat['name']],
                [
                    'slug' => Str::slug($cat['name']),
                    'type' => $cat['type'],
                    'image' => $cat['image'],
                    'is_active' => true,
                ]
            );
        }
    }
}
