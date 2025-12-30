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
            ->each(function ($product) use ($users) {
                // Create 2-5 images for each product
                $imageCount = rand(2, 5);

                for ($i = 0; $i < $imageCount; $i++) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_url' => 'https://picsum.photos/800/800?random=' . rand(1, 100000),
                    ]);
                }

                // Add reviews for 80% of products
                if (rand(1, 100) <= 80) {
                    $reviewCount = rand(1, min(8, $users->count()));

                    $reviewers = $users->random($reviewCount);

                    // random() might return a single item if not explicitly handled or in certain versions? 
                    // Actually, random(1) usually returns a collection in strict mode, but let's be safe:
                    if (!($reviewers instanceof \Illuminate\Database\Eloquent\Collection) && !($reviewers instanceof \Illuminate\Support\Collection)) {
                        $reviewers = collect([$reviewers]);
                    }

                    foreach ($reviewers as $reviewer) {
                        $rating = rand(3, 5);
                        \App\Models\Review::create([
                            'user_id' => $reviewer->id,
                            'product_id' => $product->id,
                            'rating' => $rating, // Mostly positive reviews
                            'comment' => \Database\Factories\ReviewFactory::getCommentForRating($rating),
                        ]);
                    }
                }
            });

        $this->command->info('✅ Created 30 products with complete information and reviews');

        // Show statistics
        $featuredCount = Product::where('is_featured', true)->count();
        $discountedCount = Product::whereNotNull('discounted_price')->count();
        $totalImages = ProductImage::count();
        $totalReviews = \App\Models\Review::count();
        $avgImagesPerProduct = round($totalImages / Product::count(), 1);
        $avgReviewsPerProduct = round($totalReviews / Product::count(), 1);

        $this->command->info("   - Featured products: {$featuredCount}");
        $this->command->info("   - Products with discounts: {$discountedCount}");
        $this->command->info("   - Total product images: {$totalImages}");
        $this->command->info("   - Total reviews: {$totalReviews}");
        $this->command->info("   - Average images per product: {$avgImagesPerProduct}");
        $this->command->info("   - Average reviews per product: {$avgReviewsPerProduct}");
    }
}
