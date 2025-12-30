<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public static function getCommentForRating(int $rating): string
    {
        $faker = \Faker\Factory::create();

        $comments = [
            5 => [
                'Excellent product! Highly recommend it.',
                'Amazing quality, exceeded my expectations!',
                'Best purchase I\'ve made in a long time.',
                'Outstanding! Will definitely buy again.',
                'Perfect! Exactly what I was looking for.',
                'Five stars! Absolutely love it.',
                'Superb quality and fast delivery.',
                'Couldn\'t be happier with this purchase!',
            ],
            4 => [
                'Very good product, happy with my purchase.',
                'Great quality, just a minor issue but overall satisfied.',
                'Good value for money, would recommend.',
                'Nice product, meets my expectations.',
                'Pretty good, would buy again.',
                'Solid product, no major complaints.',
                'Happy with the quality, delivery was good too.',
            ],
            3 => [
                'It\'s okay, nothing special.',
                'Average product, does the job.',
                'Not bad, but not great either.',
                'Decent quality for the price.',
                'It\'s fine, meets basic expectations.',
                'Acceptable, but could be better.',
            ],
            2 => [
                'Not what I expected, disappointed.',
                'Quality could be better.',
                'Had some issues with this product.',
                'Below average, not satisfied.',
                'Expected more for the price.',
            ],
            1 => [
                'Very disappointed with this purchase.',
                'Poor quality, would not recommend.',
                'Not worth the money at all.',
                'Terrible experience, avoid this product.',
            ],
        ];

        return $faker->randomElement($comments[$rating] ?? $comments[3]);
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rating = $this->faker->numberBetween(1, 5);

        return [
            'user_id' => \App\Models\User::inRandomOrder()->first()?->id ?? 1,
            'product_id' => \App\Models\Product::inRandomOrder()->first()?->id ?? 1,
            'rating' => $rating,
            'comment' => self::getCommentForRating($rating),
        ];
    }
}
