<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have users and categories
        $users = User::all();
        $categories = Category::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            $this->command->error('Please run UserSeeder and CategorySeeder first!');
            return;
        }

        // Create 30 products with complete information
        Product::factory()
            ->count(30)
            ->create()
            ->each(function ($product) {
                // Create 2-5 images for each product
                $imageCount = rand(2, 5);

                for ($i = 0; $i < $imageCount; $i++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => 'https://picsum.photos/800/800?random=' . rand(1, 100000),
                    ]);
                }
            });

        $this->command->info('✅ Created 30 products with complete information');

        // Show statistics
        $featuredCount = Product::where('is_featured', true)->count();
        $discountedCount = Product::whereNotNull('discounted_price')->count();
        $totalImages = ProductImage::count();
        $avgImagesPerProduct = round($totalImages / Product::count(), 1);

        $this->command->info("   - Featured products: {$featuredCount}");
        $this->command->info("   - Products with discounts: {$discountedCount}");
        $this->command->info("   - Total product images: {$totalImages}");
        $this->command->info("   - Average images per product: {$avgImagesPerProduct}");
    }
}
