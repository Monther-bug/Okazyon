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

        // 1. Specific Products for Demo Seller (منذر بوتيك)
        $demoProducts = [
            [
                'category_slug' => 'fashion',
                'name' => 'جاكيت جينز عتيق',
                'description' => 'جاكيت جينز كلاسيكي عتيق بجودة عالية، مثالي لجميع المواسم. يتميز بتصميم مريح ومتين وخيوط قوية.',
                'price' => 450.00,
                'discounted_price' => 350.00,
                'image_url' => 'https://images.unsplash.com/photo-1543087904-142c792e4752?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?q=80&w=800',
                    'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?q=80&w=800',
                    'https://images.unsplash.com/photo-1551028719-00167b16eac5?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'electronics',
                'name' => 'سماعات بلوتوث عازلة للضوضاء',
                'description' => 'سماعات لاسلكية حديثة مع تقنية إلغاء الضوضاء الفائقة وعمر بطارية يصل إلى 40 ساعة.',
                'price' => 899.00,
                'discounted_price' => 649.00,
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1546435770-a3e426bf472b?q=80&w=800',
                    'https://images.unsplash.com/photo-1583394838336-acd9929a5f91?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'food-beverages',
                'name' => 'طقم قهوة مختصة أثيوبية',
                'description' => 'بن أثيوبي فاخر محمص بعناية، يتميز بإيحاءات الفواكه والزهور. الوزن 250 جرام.',
                'price' => 85.00,
                'discounted_price' => 75.00,
                'image_url' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?q=80&w=800',
                'storage_instructions' => 'يحفظ في مكان بارد وجاف بعيداً عن أشعة الشمس المباشرة.',
                'expiration_date' => now()->addMonths(6),
                'images' => [
                    'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'furniture',
                'name' => 'طاولة قهوة من خشب البلوط الحديث',
                'description' => 'طاولة قهوة مصنوعة يدويًا من خشب البلوط الطبيعي بتصميم عصري بسيط يناسب غرف المعيشة الحديثة.',
                'price' => 1200.00,
                'discounted_price' => 950.00,
                'image_url' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1540932239986-30128078f3c5?q=80&w=800',
                    'https://images.unsplash.com/photo-1503602642458-232111445657?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'health-beauty',
                'name' => 'طقم العناية بالبشرة العضوي',
                'description' => 'مجموعة كاملة من منتجات العناية بالبشرة المصنوعة من مكونات طبيعية 100% لبشرة نضرة وصحية.',
                'price' => 450.00,
                'discounted_price' => 380.00,
                'image_url' => 'https://images.unsplash.com/photo-1556228720-195a672e8a03?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?q=80&w=800',
                    'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?q=80&w=800',
                ],
            ],
        ];

        foreach ($demoProducts as $pData) {
            $cat = $categories[$pData['category_slug']] ?? null;
            if (!$cat)
                continue;

            $product = Product::updateOrCreate(
                ['name' => $pData['name'], 'user_id' => $demoSeller->id],
                [
                    'category_id' => $cat->id,
                    'description' => $pData['description'],
                    'price' => $pData['price'],
                    'discounted_price' => $pData['discounted_price'],
                    'image_url' => $pData['image_url'],
                    'status' => 'approved',
                    'is_featured' => rand(0, 1),
                    'expiration_date' => $pData['expiration_date'] ?? null,
                    'storage_instructions' => $pData['storage_instructions'] ?? null,
                ]
            );

            // Clear old images if any and re-add
            $product->images()->delete();
            foreach ($pData['images'] as $imgUrl) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imgUrl,
                ]);
            }
        }

        // 2. Random Products for other sellers to fill the database
        $otherSellers = User::role('seller')->where('id', '!=', $demoSeller->id)->get();
        $randomProductPool = [
            [
                'category' => 'electronics',
                'name' => 'آيفون 15 برو ماكس',
                'desc' => 'أحدث هاتف من آبل مع كاميرا سينمائية ومعالج جبار.',
                'price' => 5000,
                'images' => ['https://images.unsplash.com/photo-1696446701796-da61225697cc?q=80&w=800']
            ],
            [
                'category' => 'fashion',
                'name' => 'فستان سهرة كلاسيكي',
                'desc' => 'فستان سهرة طويل بلون أسود جذاب وتصميم ملكي.',
                'price' => 1200,
                'images' => ['https://images.unsplash.com/photo-1518767761162-d533515aadf3?q=80&w=800']
            ],
            [
                'category' => 'food-beverages',
                'name' => 'عسل سدر كشميري',
                'desc' => 'عسل طبيعي نقي 100% غني بالعناصر الغذائية والفوائد الصحية.',
                'price' => 150,
                'storage_instructions' => 'يحفظ في درجة حرارة الغرفة.',
                'images' => ['https://images.unsplash.com/photo-1587049352846-4a222e784d38?q=80&w=800']
            ],
            [
                'category' => 'furniture',
                'name' => 'أريكة مخملية فاخرة',
                'desc' => 'أريكة مريحة جداً تناسب الصالات الواسعة والمكاتب الفخمة.',
                'price' => 3500,
                'images' => ['https://images.unsplash.com/photo-1555041469-a586c61ea9bc?q=80&w=800']
            ],
            [
                'category' => 'home-appliances',
                'name' => 'قلاية هوائية ذكية',
                'desc' => 'اطبخ طعامك الصحي بملعقة زيت واحدة فقط وبنتائج مذهلة.',
                'price' => 600,
                'images' => ['https://images.unsplash.com/photo-1626739011274-762bc218de0c?q=80&w=800']
            ],
            [
                'category' => 'toys-kids',
                'name' => 'سيارة تحكم عن بعد',
                'desc' => 'سيارة سريعة جداً وقوية تتحمل الصدمات مخصصة للأطفال فوق 10 سنوات.',
                'price' => 250,
                'images' => ['https://images.unsplash.com/photo-1581235720704-06d3acfc136f?q=80&w=800']
            ],
            [
                'category' => 'automotive',
                'name' => 'طقم إطارات رياضية',
                'desc' => 'أفضل أنواع الإطارات التي توفر ثباتاً عالياً على الطرق السريعة.',
                'price' => 2000,
                'images' => ['https://images.unsplash.com/photo-1550009158-9ebf69173e03?q=80&w=800']
            ],
            [
                'category' => 'health-beauty',
                'name' => 'عطر فرنسي أصلي',
                'desc' => 'رائحة تدوم طويلاً وتناسب جميع المناسبات الرسمية والخاصة.',
                'price' => 450,
                'images' => ['https://images.unsplash.com/photo-1541643600914-78b084683601?q=80&w=800']
            ],
            [
                'category' => 'sports',
                'name' => 'دراجة هوائية جبلية',
                'desc' => 'دراجة خفيفة الوزن ومتينة مصممة للطرق الوعرة والجبلية.',
                'price' => 1800,
                'images' => ['https://images.unsplash.com/photo-1485965120184-e220f721d03e?q=80&w=800']
            ],
            [
                'category' => 'consumer-goods',
                'name' => 'منظف أسطح متعدد الاستخدامات',
                'desc' => 'منظف فعال يقضي على 99% من الجراثيم ويترك رائحة منعشة.',
                'price' => 25,
                'images' => ['https://images.unsplash.com/photo-1584622781564-1d9876a13d00?q=80&w=800']
            ],
        ];

        foreach ($otherSellers as $seller) {
            $poolIndices = array_rand($randomProductPool, 4); // Seed 4 products per random seller
            foreach ($poolIndices as $poolIndex) {
                $pData = $randomProductPool[$poolIndex];
                $cat = $categories[$pData['category']] ?? null;
                if (!$cat)
                    continue;

                $product = Product::updateOrCreate(
                    ['name' => $pData['name'], 'user_id' => $seller->id],
                    [
                        'category_id' => $cat->id,
                        'description' => $pData['desc'],
                        'price' => $pData['price'],
                        'discounted_price' => $pData['price'] * 0.8,
                        'image_url' => $pData['images'][0],
                        'status' => 'approved',
                        'is_featured' => rand(0, 1),
                        'storage_instructions' => $pData['storage_instructions'] ?? null,
                    ]
                );

                $product->images()->delete();
                foreach ($pData['images'] as $imgUrl) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $imgUrl,
                    ]);
                }
            }
        }
    }
}
