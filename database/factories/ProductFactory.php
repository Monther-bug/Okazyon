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

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? 1,
            'category_id' => Category::inRandomOrder()->first()?->id ?? 1,
            'name' => $this->faker->randomElement([
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
            ]) . ' - ' . $this->faker->word(),
            'description' => $this->faker->paragraph(3),
            'price' => $price,
            'discounted_price' => $hasDiscount ? $this->faker->randomFloat(2, $price * 0.5, $price * 0.9) : null,
            'status' => 'approved',
            'is_featured' => $this->faker->boolean(30), // 30% chance of being featured
            'expiration_date' => $this->faker->dateTimeBetween('+1 week', '+6 months'),
            'storage_instructions' => $this->faker->randomElement([
                'Store in a cool, dry place',
                'Keep refrigerated after opening',
                'Store at room temperature',
                'Keep frozen until ready to use',
                'Refrigerate immediately',
            ]),
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
