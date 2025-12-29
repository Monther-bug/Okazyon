<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    protected $model = Banner::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement([
                'Summer Sale - Up to 50% Off!',
                'New Arrivals Just Landed',
                'Flash Deal - Limited Time Only',
                'Weekend Special Offers',
                'Buy 2 Get 1 Free',
            ]),
            'subtitle' => $this->faker->randomElement([
                'Shop now and save big on your favorite products',
                'Discover amazing deals on top brands',
                'Don\'t miss out on these incredible savings',
                'Limited stock available - order today',
                'Free shipping on orders over $50',
            ]),
            'image' => 'https://picsum.photos/1200/400?random=' . $this->faker->numberBetween(1, 1000),
            'link' => $this->faker->optional(0.7)->url(),
            'is_active' => false,
        ];
    }

    /**
     * Indicate that the banner is active.
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'is_active' => true,
        ]);
    }
}
