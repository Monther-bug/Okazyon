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
        $banners = [
            [
                'title' => 'عروض الأزياء الكبرى',
                'subtitle' => 'خصم يصل إلى 50% على الملابس العصرية',
                'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=1200',
                'link' => '/categories/fashion',
            ],
            [
                'title' => 'تذوق أشهى المأكولات',
                'subtitle' => 'عروض حصرية من أفضل المطاعم المحلية',
                'image' => 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=1200',
                'link' => '/categories/food-dining',
            ],
            [
                'title' => 'أثاث منزلي عصري',
                'subtitle' => 'جدد منزلك بأرقى التصاميم بأسعار مخفضة',
                'image' => 'https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?q=80&w=1200',
                'link' => '/categories/furniture',
            ],
        ];

        foreach ($banners as $banner) {
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
