<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use Database\Seeders\Traits\HasSeedImages;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    use HasSeedImages;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Get the Demo Seller (Updated to use phone number)
        $demoSeller = User::where('phone_number', '0910000000')->first();

        // 2. Specific High-Quality Products for Demo Seller
        if ($demoSeller) {
            $this->createDemoProducts($demoSeller);
        }

        // 3. Random Products for other Sellers
        $otherSellers = User::role('seller')->where('phone_number', '!=', '0910000000')->get();
        $categories = Category::all();

        if ($categories->isEmpty()) {
            return;
        }

        foreach ($otherSellers as $seller) {
            // Create 20 random products for each seller (Increased from 15)
            Product::factory(20)->create([
                'user_id' => $seller->id,
                'category_id' => $categories->random()->id,
                'status' => 'approved',
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=800',
            ])->each(function ($product) {
                // Attach to Spatie Media Library using local cache
                try {
                    $localPath = $this->getLocalImage($product->image_url);
                    if ($localPath) {
                        $product->addMedia($localPath)
                            ->preservingOriginal()
                            ->toMediaCollection('images');
                    }
                } catch (\Exception $e) {
                }

                // Add 4 secondary images (Increased from 2)
                ProductImage::factory(4)->create([
                    'product_id' => $product->id,
                    'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=800',
                ]);
            });
        }
    }

    private function createDemoProducts(User $seller)
    {
        $fashion = Category::where('slug', 'fashion')->first();
        $furniture = Category::where('slug', 'furniture')->first();
        $food = Category::where('slug', 'food-dining')->first();
        $sports = Category::where('slug', 'sports')->first();
        $books = Category::where('slug', 'books')->first();
        $electronics = Category::where('slug', 'electronics')->first();
        $home = Category::where('slug', 'home-garden')->first();

        $products = [
            // Electronics Items (NEW)
            [
                'category' => $electronics,
                'name' => 'Noise Cancelling Wireless Headphones',
                'description' => 'Premium over-ear headphones with active noise cancellation. 30-hour battery life.',
                'price' => 299.00,
                'discounted_price' => 249.00,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1484704849700-f032a568e944?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1524678606370-a47ad25cb82a?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1613040809024-b4ef7ba99bc3?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $electronics,
                'name' => 'Smart Fitness Watch',
                'description' => 'Track your workouts, heart rate, and sleep. Water-resistant and stylish.',
                'price' => 150.00,
                'discounted_price' => 129.00,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1579586337278-3befd40fd17a?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1434493789847-2f02dc6ca35d?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1510017803434-a899398421b3?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $electronics,
                'name' => 'Portable Bluetooth Speaker',
                'description' => 'Compact speaker with powerful sound. Waterproof design for outdoor adventures.',
                'price' => 60.00,
                'discounted_price' => 45.00,
                'image' => 'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1608043152269-423dbba4e7e1?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1589256469067-ea99122bb568?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1613532653198-e4b9fdbe153f?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            // Home & Garden Items (NEW)
            [
                'category' => $home,
                'name' => 'Ceramic Plant Pot Set',
                'description' => 'Set of 3 minimalist ceramic planters using natural materials. Perfect for succulents.',
                'price' => 35.00,
                'discounted_price' => null,
                'image' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1463936575229-460130d72061?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1520412099551-62b6bafeb5bb?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $home,
                'name' => 'Modern LED Desk Lamp',
                'description' => 'Adjustable LED desk lamp with touch controls. Eye-caring light technology.',
                'price' => 45.00,
                'discounted_price' => 35.00,
                'image' => 'https://images.unsplash.com/photo-1534073828943-f801091a7d58?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1534073828943-f801091a7d58?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1513506003013-1b6343467475?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1507473888900-52e1ad1d6904?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            // Fashion Items
            [
                'category' => $fashion,
                'name' => 'Vintage Denim Jacket',
                'description' => 'Authentic vintage denim jacket in excellent condition. Perfect for a casual look.',
                'price' => 85.00,
                'discounted_price' => 65.00,
                'image' => 'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1576995853123-5a10305d93c0?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1551537482-f2096325934e?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1542272617-08f08630329f?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1620799140408-ed5341cd2431?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $fashion,
                'name' => 'Surplus Designer Sneakers',
                'description' => 'Brand new designer sneakers. Limited stock available. Great comfort and style.',
                'price' => 120.00,
                'discounted_price' => null,
                'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1560769629-975ec94e6a86?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1491553895911-0055eca6402d?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $fashion,
                'name' => 'Leather Satchel Bag',
                'description' => 'Genuine leather satchel, perfect for work or daily use. High quality stitching.',
                'price' => 95.00,
                'discounted_price' => 80.00,
                'image' => 'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1590874103328-eac38a683ce7?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1590874103504-2b63884e12ec?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1585488763157-55866b177d61?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $fashion,
                'name' => 'Silk Scarf',
                'description' => 'Elegant silk scarf with a unique pattern. Adds a touch of luxury to any outfit.',
                'price' => 55.00,
                'discounted_price' => null,
                'image' => 'https://images.unsplash.com/photo-1584030373081-f37b7bb4fa8e?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1584030373081-f37b7bb4fa8e?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1601924582970-9238bcb495d9?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1599643478518-17488fbbcd75?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            // Furniture Items
            [
                'category' => $furniture,
                'name' => 'Modern Oak Coffee Table',
                'description' => 'Beautifully crafted oak coffee table with a minimalist design. Surplus stock from a high-end showroom.',
                'price' => 250.00,
                'discounted_price' => 199.00,
                'image' => 'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1594056156976-1936336cd7b1?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1532372320572-cda25653db36?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1574621175043-4dc975734301?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $furniture,
                'name' => 'Lounge Armchair',
                'description' => 'Comfortable armchair upholstered in grey fabric. Dead stock item, never used.',
                'price' => 180.00,
                'discounted_price' => 150.00,
                'image' => 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1567538096630-e0c55bd6374c?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1567538096621-38d2284b233a?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $furniture,
                'name' => 'Wooden Nightstand',
                'description' => 'Compact and stylish wooden nightstand. Features a single drawer for storage.',
                'price' => 110.00,
                'discounted_price' => 90.00,
                'image' => 'https://images.unsplash.com/photo-1532372320572-cda25653db36?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1532372320572-cda25653db36?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1595846519845-68e298c2edd8?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1610427670783-da83c6b22ebc?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1505693416388-b0346efee958?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            // Food Items
            [
                'category' => $food,
                'name' => 'Organic Honey Jar',
                'description' => 'Pure organic honey, gathered from local wildflowers. Rich taste and perfect for tea or baking.',
                'price' => 25.00,
                'discounted_price' => 20.00,
                'image' => 'https://images.unsplash.com/photo-1587049359530-4daa5e3e3ddc?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1587049359530-4daa5e3e3ddc?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1612476712399-556488d75cf7?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1471943311424-646960669fbc?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $food,
                'name' => 'Artisan Coffee Beans',
                'description' => 'Freshly roasted artisan coffee beans. A smooth blend with hints of chocolate and caramel.',
                'price' => 18.00,
                'discounted_price' => 15.00,
                'image' => 'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1498804103079-a6351b050096?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            // Sports Items
            [
                'category' => $sports,
                'name' => 'Pro Yoga Mat',
                'description' => 'High-density foam yoga mat for extra comfort and durability. Non-slip surface.',
                'price' => 45.00,
                'discounted_price' => 35.00,
                'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1576678927484-cc907957088c?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1545247181-516773cae754?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1599447421405-0cbe872364c3?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $sports,
                'name' => 'Dumbbell Set',
                'description' => 'Complete set of dumbbells for home workouts. Neoprene coated for grip.',
                'price' => 60.00,
                'discounted_price' => 50.00,
                'image' => 'https://images.unsplash.com/photo-1638536532686-d610adfc8e5c?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1638536532686-d610adfc8e5c?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1599058945522-28d584b6f0ff?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            // Books
            [
                'category' => $books,
                'name' => 'Design Patterns Book',
                'description' => 'Classic programming book on software design patterns. Essential for developers.',
                'price' => 45.00,
                'discounted_price' => 30.00,
                'image' => 'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1544947950-fa07a98d237f?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1512820790803-83ca734da794?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $books,
                'name' => 'Gourmet Cooking Guide',
                'description' => 'Hardcover cookbook featuring recipes from world-renowned chefs. Beautiful photography.',
                'price' => 35.00,
                'discounted_price' => null,
                'image' => 'https://images.unsplash.com/photo-1592150621744-aca64f48394a?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1592150621744-aca64f48394a?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1546964124-0cce460f38ef?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1589652717521-10c0d092dea9?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1532012197267-da84d127e765?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            [
                'category' => $books,
                'name' => 'History of Art',
                'description' => 'Comprehensive visual history of art movements. High-quality print.',
                'price' => 70.00,
                'discounted_price' => 60.00,
                'image' => 'https://images.unsplash.com/photo-1536965764833-5971e0abed7c?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1536965764833-5971e0abed7c?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1589829085413-56de8ae18c73?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1549675583-4a1e96152a26?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1544716278-ca5e3f4abd8c?auto=format&fit=crop&q=80&w=800',
                ]
            ],
            // More Fashion
            [
                'category' => $fashion,
                'name' => 'Classic Wool Coat',
                'description' => 'Timeless wool coat in charcoal grey. Warm and stylish for winter.',
                'price' => 150.00,
                'discounted_price' => 130.00,
                'image' => 'https://images.unsplash.com/photo-1544923246-77307dd654cb?auto=format&fit=crop&q=80&w=800',
                'extra_images' => [
                    'https://images.unsplash.com/photo-1544923246-77307dd654cb?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1539533018447-63fcce667c1f?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?auto=format&fit=crop&q=80&w=800',
                    'https://images.unsplash.com/photo-1487222477894-8943e31ef7b2?auto=format&fit=crop&q=80&w=800',
                ]
            ]
        ];

        foreach ($products as $data) {
            if (!$data['category'])
                continue;

            $product = Product::create([
                'user_id' => $seller->id,
                'category_id' => $data['category']->id,
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'discounted_price' => $data['discounted_price'],
                'image_url' => $data['image'],
                'status' => 'approved',
                'is_featured' => true,
            ]);

            // Attach Main Image (Using Local Cache)
            try {
                $localPath = $this->getLocalImage($data['image']);
                if ($localPath) {
                    $product->addMedia($localPath)
                        ->preservingOriginal()
                        ->toMediaCollection('images');
                }
            } catch (\Exception $e) {
            }


            // Add images
            if (isset($data['extra_images'])) {
                foreach ($data['extra_images'] as $imgUrl) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => $imgUrl,
                    ]);

                    // Attach extra images to media library too (optional but recommended for consistency)
                    try {
                        $localPath = $this->getLocalImage($imgUrl);
                        if ($localPath) {
                            $product->addMedia($localPath)
                                ->preservingOriginal()
                                ->toMediaCollection('images');
                        }
                    } catch (\Exception $e) {
                    }
                }
            }
        }
    }
}
