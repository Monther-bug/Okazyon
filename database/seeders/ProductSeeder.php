<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $demoSeller = User::where('email', 'seller@okazyon.com')->first();
        if (!$demoSeller)
            return;

        $categories = Category::all()->keyBy('slug');

        // 1. Specific Products for Demo Seller
        $demoProducts = [
            [
                'category_slug' => 'fashion',
                'name' => 'جاكيت جينز عتيق',
                'description' => 'جاكيت جينز كلاسيكي عتيق بجودة عالية، مثالي لجميع المواسم. يتميز بتصميم مريح ومتين.',
                'price' => 450.00,
                'discounted_price' => 350.00,
                'image_url' => 'https://images.unsplash.com/photo-1576905324223-5e7304ae0998?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1544642899-f0d6e5f6ed6f?q=80&w=800',
                    'https://images.unsplash.com/photo-1523205771623-e0faa4d2813d?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'furniture',
                'name' => 'طاولة قهوة من خشب البلوط الحديث',
                'description' => 'طاولة قهوة مصنوعة يدويًا من خشب البلوط الطبيعي بتصميم عصري بسيط يناسب غرف المعيشة الحديثة.',
                'price' => 1200.00,
                'discounted_price' => 950.00,
                'image_url' => 'https://images.unsplash.com/photo-1533090161767-e6ffed986c88?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1581428982868-e410dd047a90?q=80&w=800',
                    'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'fashion',
                'name' => 'أحذية رياضية فاخرة فائضة',
                'description' => 'أحذية رياضية من ماركات عالمية فائضة عن الإنتاج، توفر راحة قصوى وأداءً متميزًا.',
                'price' => 850.00,
                'discounted_price' => 600.00,
                'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1551107696-a4b0c5a0d9a2?q=80&w=800',
                    'https://images.unsplash.com/photo-1560769629-975ec94e6a86?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'fashion',
                'name' => 'فستان صيفي مزهر',
                'description' => 'فستان صيفي خفيف وأنيق بنقشة الزهور، مصنوع من ألياف طبيعية تسمح بمرور الهواء.',
                'price' => 320.00,
                'discounted_price' => 250.00,
                'image_url' => 'https://images.unsplash.com/photo-1515378791036-0648a3ef77b2?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'furniture',
                'name' => 'مصباح مكتبي بتصميم صناعي',
                'description' => 'مصباح مكتبي يجمع بين المعدن والخشب بتصميم صناعي فريد، يضيف لمسة فنية لمساحة العمل الخاصة بك.',
                'price' => 280.00,
                'discounted_price' => 190.00,
                'image_url' => 'https://images.unsplash.com/photo-1534073828943-f801091bb18c?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1507473885765-e6ed657f782c?q=80&w=800',
                ],
            ],
        ];

        foreach ($demoProducts as $pData) {
            $cat = $categories[$pData['category_slug']] ?? null;
            if (!$cat)
                continue;

            $product = Product::create([
                'user_id' => $demoSeller->id,
                'category_id' => $cat->id,
                'name' => $pData['name'],
                'description' => $pData['description'],
                'price' => $pData['price'],
                'discounted_price' => $pData['discounted_price'],
                'image_url' => $pData['image_url'],
                'status' => 'approved',
                'is_featured' => rand(0, 1),
                'expiration_date' => $cat->type === 'food' ? now()->addMonths(3) : null,
            ]);

            foreach ($pData['images'] as $imgUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imgUrl,
                ]);
            }
        }

        // 2. Random Products for other sellers
        $otherSellers = User::role('seller')->where('id', '!=', $demoSeller->id)->get();
        $randomProductPool = [
            ['category' => 'sports', 'name' => 'بساط يوغا احترافي', 'desc' => 'بساط يوغا غير قابل للانزلاق مع توسيد ممتاز لحماية المفاصل.'],
            ['category' => 'books', 'name' => 'رواية ملحمة الصحراء', 'desc' => 'رواية خيالية تدور أحداثها في قلب الصحراء العربية، مليئة بالمغامرة والدراما.'],
            ['category' => 'food-dining', 'name' => 'عسل نحل طبيعي', 'desc' => 'عسل نحل خام عالي الجودة مستخلص من زهور الربيع البرية.'],
            ['category' => 'sports', 'name' => 'طقم أوزان رياضية', 'desc' => 'طقم من 12 قطعة من الأوزان الحديدية المطلية بالمطاط للتمارين المنزلية.'],
            ['category' => 'books', 'name' => 'تعلم الذكاء الاصطناعي باللغة العربية', 'desc' => 'دليل شامل لتعلم مبادئ الذكاء الاصطناعي وتطبيقاته العملية.'],
            ['category' => 'food-dining', 'name' => 'زيت زيتون بكر ممتاز', 'desc' => 'زيت زيتون عصرة أولى باردة، يتميز بطعم قوي ورائحة عطرية.'],
        ];

        foreach ($otherSellers as $seller) {
            foreach (array_rand($randomProductPool, 3) as $poolIndex) {
                $pData = $randomProductPool[$poolIndex];
                $cat = $categories[$pData['category']] ?? null;
                if (!$cat)
                    continue;

                $product = Product::create([
                    'user_id' => $seller->id,
                    'category_id' => $cat->id,
                    'name' => $pData['name'],
                    'description' => $pData['desc'],
                    'price' => rand(100, 1000),
                    'discounted_price' => rand(50, 400),
                    'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=800', // Default placeholder for random
                    'status' => 'approved',
                    'is_featured' => rand(0, 1),
                    'expiration_date' => $cat->type === 'food' ? now()->addMonths(6) : null,
                ]);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=800',
                ]);
            }
        }
    }
}
