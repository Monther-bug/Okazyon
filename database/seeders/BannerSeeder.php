<?php

namespace Database\Seeders;

use App\Models\Banner;
use Database\Seeders\Traits\HasSeedImages;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    use HasSeedImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Big Summer Sale',
                'subtitle' => 'Up into 50% Off Fashion Items',
                'image' => 'https://images.unsplash.com/photo-1483985988355-763728e1935b?auto=format&fit=crop&q=80&w=1200',
                'link' => '/category/fashion',
            ],
            [
                'title' => 'Fresh Food Deals',
                'subtitle' => 'Get the best organic surplus food',
                'image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&q=80&w=1200',
                'link' => '/category/food',
            ],
            [
                'title' => 'Modern Furniture',
                'subtitle' => 'Upgrade your home for less',
                'image' => 'https://images.unsplash.com/photo-1618220179428-22790b461013?auto=format&fit=crop&q=80&w=1200',
                'link' => '/category/furniture',
            ],
        ];

        foreach ($banners as $banner) {
            // Cache locally
            $this->getLocalImage($banner['image']);

            Banner::create([
                'title' => $banner['title'],
                'subtitle' => $banner['subtitle'],
                'image' => $banner['image'],
                'link' => $banner['link'],
                'is_active' => true,
            ]);
        }
    }
}
