<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 banners with images
        Banner::factory()->active()->create([
            'title' => 'Special Holiday Sale - Up to 70% Off!',
            'subtitle' => 'Shop now and enjoy massive discounts on all categories',
            'image' => 'https://picsum.photos/1200/400?random=1',
            'link' => null,
        ]);

        Banner::factory()->create([
            'title' => 'Summer Collection - New Arrivals',
            'subtitle' => 'Discover the latest trends and styles',
            'image' => 'https://picsum.photos/1200/400?random=2',
            'link' => null,
        ]);

        Banner::factory()->create([
            'title' => 'Flash Deal - Limited Time Only',
            'subtitle' => 'Don\'t miss out on these incredible savings',
            'image' => 'https://picsum.photos/1200/400?random=3',
            'link' => null,
        ]);

        Banner::factory()->create([
            'title' => 'Weekend Special Offers',
            'subtitle' => 'Free shipping on orders over $50',
            'image' => 'https://picsum.photos/1200/400?random=4',
            'link' => null,
        ]);

        Banner::factory()->create([
            'title' => 'Buy 2 Get 1 Free',
            'subtitle' => 'Limited stock available - order today',
            'image' => 'https://picsum.photos/1200/400?random=5',
            'link' => null,
        ]);

        $this->command->info('✅ Created 5 banners (1 active) with images');
    }
}
