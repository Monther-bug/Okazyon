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
                'description' => 'جاكيت جينز كلاسيكي عتيق بجودة عالية، مثالي لجميع المواسم. يتميز بتصميم مريح ومتين.',
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
                'category_slug' => 'furniture',
                'name' => 'طاولة قهوة من خشب البلوط الحديث',
                'description' => 'طاولة قهوة مصنوعة يدويًا من خشب البلوط الطبيعي بتصميم عصري بسيط يناسب غرف المعيشة الحديثة.',
                'price' => 1200.00,
                'discounted_price' => 950.00,
                'image_url' => 'https://images.unsplash.com/photo-1505693416388-ac5ce068fe85?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1540932239986-30128078f3c5?q=80&w=800',
                    'https://images.unsplash.com/photo-1503602642458-232111445657?q=80&w=800',
                    'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'fashion',
                'name' => 'أحذية رياضية فاخرة فائضة',
                'description' => 'أحذية رياضية من ماركات عالمية فائضة عن الإنتاج، توفر راحة قصوى وأداءً متميزًا.',
                'price' => 850.00,
                'discounted_price' => 600.00,
                'image_url' => 'https://images.unsplash.com/photo-1511556532299-8f662fc26c06?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1515955656352-a1fa3ffcdda9?q=80&w=800',
                    'https://images.unsplash.com/photo-1491553895911-0055eca6402d?q=80&w=800',
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ab?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'fashion',
                'name' => 'فستان صيفي مزهر',
                'description' => 'فستان صيفي خفيف وأنيق بنقشة الزهور، مصنوع من ألياف طبيعية تسمح بمرور الهواء.',
                'price' => 320.00,
                'discounted_price' => 250.00,
                'image_url' => 'https://images.unsplash.com/photo-1594633312681-425c7b97ccd1?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1590486829697-0335b9493f68?q=80&w=800',
                    'https://images.unsplash.com/photo-1515243169879-da35f5c1d1a1?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'goods',
                'name' => 'حقيبة ظهر للمغامرات',
                'description' => 'حقيبة ظهر متينة ومقاومة للماء، مثالية للرحلات الطويلة والمغامرات في الهواء الطلق.',
                'price' => 350.00,
                'discounted_price' => 280.00,
                'image_url' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1509762774605-f07235a08f1f?q=80&w=800',
                ],
            ],
            [
                'category_slug' => 'food-dining',
                'name' => 'طقم قهوة سيراميك يدوي',
                'description' => 'طقم قهوة فاخر مصنوع يدويًا من السيراميك، يجمع بين الأصالة والحداثة في تصميم واحد.',
                'price' => 150.00,
                'discounted_price' => 120.00,
                'image_url' => 'https://images.unsplash.com/photo-1517705008128-361805f42e8a?q=80&w=800',
                'images' => [
                    'https://images.unsplash.com/photo-1481833761820-0509d3217039?q=80&w=800',
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
            [
                'category' => 'sports',
                'name' => 'بساط يوغا احترافي',
                'desc' => 'بساط يوغا غير قابل للانزلاق مع توسيد ممتاز لحماية المفاصل.',
                'images' => [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?q=80&w=800',
                    'https://images.unsplash.com/photo-1592432676556-268a810426f2?q=80&w=800'
                ]
            ],
            [
                'category' => 'books',
                'name' => 'رواية ملحمة الصحراء',
                'desc' => 'رواية خيالية تدور أحداثها في قلب الصحراء العربية، مليئة بالمغامرة والدراما.',
                'images' => [
                    'https://images.unsplash.com/photo-1512820790803-83ca734da794?q=80&w=800',
                    'https://images.unsplash.com/photo-1544947950-fa07a98d237f?q=80&w=800'
                ]
            ],
            [
                'category' => 'food-dining',
                'name' => 'عسل نحل طبيعي',
                'desc' => 'عسل نحل خام عالي الجودة مستخلص من زهور الربيع البرية.',
                'images' => [
                    'https://images.unsplash.com/photo-1587049352846-4a222e784d38?q=80&w=800',
                    'https://images.unsplash.com/photo-1471193945509-9ad0617afabf?q=80&w=800'
                ]
            ],
            [
                'category' => 'sports',
                'name' => 'طقم أوزان رياضية',
                'desc' => 'طقم من 12 قطعة من الأوزان الحديدية المطلية بالمطاط للتمارين المنزلية.',
                'images' => [
                    'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=800',
                    'https://images.unsplash.com/photo-1581009146145-b5ef03a94e77?q=80&w=800'
                ]
            ],
            [
                'category' => 'books',
                'name' => 'تعلم الذكاء الاصطناعي',
                'desc' => 'دليل شامل لتعلم مبادئ الذكاء الاصطناعي وتطبيقاته العملية باللغة العربية.',
                'images' => [
                    'https://images.unsplash.com/photo-1509228468518-180dd4864904?q=80&w=800',
                    'https://images.unsplash.com/photo-1591453089816-0fbb971b454c?q=80&w=800'
                ]
            ],
            [
                'category' => 'food-dining',
                'name' => 'زيت زيتون بكر ممتاز',
                'desc' => 'زيت زيتون عصرة أولى باردة، يتميز بطعم قوي ورائحة عطرية.',
                'images' => [
                    'https://images.unsplash.com/photo-1474979266404-7eaacbadcbaf?q=80&w=800',
                    'https://images.unsplash.com/photo-1464454709131-ffd692591ee5?q=80&w=800'
                ]
            ],
            [
                'category' => 'accessories',
                'name' => 'ساعة ذكية رياضية',
                'desc' => 'ساعة ذكية متطورة تتبع نشاطك البدني ومعدل ضربات القلب بدقة عالية.',
                'images' => [
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?q=80&w=800',
                    'https://images.unsplash.com/photo-1508685096489-77a468026214?q=80&w=800'
                ]
            ],
        ];

        foreach ($otherSellers as $seller) {
            $poolIndices = array_rand($randomProductPool, min(3, count($randomProductPool)));
            if (!is_array($poolIndices))
                $poolIndices = [$poolIndices];

            foreach ($poolIndices as $poolIndex) {
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
                    'image_url' => $pData['images'][0],
                    'status' => 'approved',
                    'is_featured' => rand(0, 1),
                    'expiration_date' => $cat->type === 'food' ? now()->addMonths(6) : null,
                ]);

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
