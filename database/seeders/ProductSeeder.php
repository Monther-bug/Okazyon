<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 30 products with media images
        Product::factory()
            ->count(30)
            ->create()
            ->each(function ($product) {
                // Create 1-3 images for each product using Spatie Media
                $imageCount = rand(1, 3);

                for ($i = 0; $i < $imageCount; $i++) {
                    try {
                        $product->addMediaFromUrl('https://picsum.photos/800/800?random=' . rand(1, 10000))
                            ->toMediaCollection('images');
                    } catch (\Exception $e) {
                        // Silently continue if image download fails
                        $this->command->warn("Failed to download image for product {$product->id}: {$e->getMessage()}");
                    }
                }
            });

        $this->command->info('✅ Created 30 products with media images');

        // Show statistics
        $featuredCount = Product::where('is_featured', true)->count();
        $discountedCount = Product::whereNotNull('discounted_price')->count();
        $totalMedia = \Spatie\MediaLibrary\MediaCollections\Models\Media::where('collection_name', 'images')->count();

        $this->command->info("   - Featured products: {$featuredCount}");
        $this->command->info("   - Products with discounts: {$discountedCount}");
        $this->command->info("   - Total media images: {$totalMedia}");
    }
}
