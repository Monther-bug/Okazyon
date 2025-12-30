<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = $this->faker->randomFloat(2, 10, 500);
        $hasDiscount = $this->faker->boolean(60); // 60% chance of having a discount

        $productNames = [
            'Fresh Organic Apples',
            'Premium Coffee Beans',
            'Artisan Bread Loaf',
            'Extra Virgin Olive Oil',
            'Handcrafted Chocolate Box',
            'Organic Honey Jar',
            'Gourmet Cheese Selection',
            'Fresh Pasta Pack',
            'Specialty Tea Collection',
            'Organic Vegetables Bundle',
            'Premium Wine Bottle',
            'Artisan Jam Set',
            'Fresh Bakery Cookies',
            'Organic Fruit Basket',
            'Specialty Spice Set',
            'Homemade Granola',
            'Artisan Sourdough Bread',
            'Fresh Salmon Fillet',
            'Organic Chicken Breast',
            'Premium Beef Steak',
            'Fresh Mozzarella Cheese',
            'Organic Yogurt Pack',
            'Whole Grain Cereal',
            'Natural Peanut Butter',
            'Organic Maple Syrup',
            'Fresh Orange Juice',
            'Artisan Pizza Dough',
            'Gourmet Pasta Sauce',
            'Premium Dark Chocolate',
            'Organic Almond Milk',
        ];

        $descriptions = [
            'Sourced from local farms, this premium product guarantees freshness and quality. Perfect for daily consumption and special occasions.',
            'Handpicked and carefully selected to ensure the highest quality. Rich in flavor and nutrients, ideal for health-conscious consumers.',
            'Crafted with traditional methods using only the finest ingredients. A delightful addition to any meal or gathering.',
            'Expertly prepared to preserve natural flavors and nutritional value. Enjoy the authentic taste of quality ingredients.',
            'Made with love and attention to detail, this product brings exceptional taste to your table. A must-have for food enthusiasts.',
        ];

        $storageInstructions = [
            'Store in a cool, dry place away from direct sunlight',
            'Keep refrigerated at 2-4°C after opening',
            'Store at room temperature in an airtight container',
            'Keep frozen at -18°C until ready to use',
            'Refrigerate immediately upon receipt',
            'Store in refrigerator and consume within 3 days of opening',
            'Keep in a cool place, do not freeze',
            'Store in original packaging in a dry location',
        ];

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
            'name' => $this->faker->randomElement($productNames),
            'description' => $this->faker->randomElement($descriptions),
            'price' => $price,
            'discounted_price' => $this->faker->randomFloat(2, $price * 0.5, $price * 0.9), // Always have a discount between 50-90% of price
            'status' => 'approved',
            'is_featured' => $this->faker->boolean(30), // 30% chance of being featured
            'expiration_date' => $this->faker->dateTimeBetween('+1 week', '+6 months'),
            'storage_instructions' => $this->faker->randomElement($storageInstructions),
        ];
    }

    /**
     * Indicate that the product is featured.
     */
    public function featured(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_featured' => true,
        ]);
    }

    /**
     * Indicate that the product has a discount.
     */
    public function discounted(): static
    {
        return $this->state(function (array $attributes) {
            $price = $attributes['price'];
            return [
                'discounted_price' => $this->faker->randomFloat(2, $price * 0.5, $price * 0.85),
            ];
        });
    }
}
