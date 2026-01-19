<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeeAllEndpointsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_fetch_best_discounts()
    {
        $category = Category::create([
            'name' => 'Test Category',
            'type' => 'standard',
            'is_active' => true
        ]);
        $user = User::factory()->create();

        Product::factory()->count(5)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'approved',
            'price' => 100,
            'discounted_price' => 50, // 50% discount
        ]);

        Product::factory()->count(5)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'approved',
            'price' => 100,
            'discounted_price' => 90, // 10% discount
        ]);

        $response = $this->getJson('/api/v1/home/best-discounts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'discount_percentage']
                ],
                'total',
                'per_page'
            ]);

        // Assert that the first item has higher discount percentage than the last (simplified check)
        $data = $response->json('data');
        $this->assertTrue($data[0]['discount_percentage'] >= $data[count($data) - 1]['discount_percentage']);
    }

    public function test_can_fetch_category_highlights()
    {
        $category = Category::create([
            'name' => 'Highight Category',
            'type' => 'standard',
            'is_active' => true
        ]);
        $user = User::factory()->create();

        Product::factory()->count(3)->create([
            'category_id' => $category->id,
            'user_id' => $user->id,
            'status' => 'approved',
        ]);

        $response = $this->getJson('/api/v1/home/category-highlights');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'total'
            ]);
    }

    public function test_can_fetch_fresh_deals()
    {
        $foodCategory = Category::create([
            'name' => 'Food Category',
            'type' => 'food',
            'is_active' => true
        ]);
        $otherCategory = Category::create([
            'name' => 'Other Category',
            'type' => 'standard',
            'is_active' => true
        ]);
        $user = User::factory()->create();

        $foodProduct = Product::factory()->create([
            'category_id' => $foodCategory->id,
            'user_id' => $user->id,
            'status' => 'approved',
            'name' => 'Apple' // Food
        ]);

        $otherProduct = Product::factory()->create([
            'category_id' => $otherCategory->id,
            'user_id' => $user->id,
            'status' => 'approved',
            'name' => 'Shirt' // Not Food
        ]);

        $response = $this->getJson('/api/v1/products/fresh-deals');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Apple'])
            ->assertJsonMissing(['name' => 'Shirt']);
    }

    public function test_can_fetch_store_finds()
    {
        $foodCategory = Category::create([
            'name' => 'Food Category 2',
            'type' => 'food',
            'is_active' => true
        ]);
        $otherCategory = Category::create([
            'name' => 'Other Category 2',
            'type' => 'standard',
            'is_active' => true
        ]);
        $user = User::factory()->create();

        $foodProduct = Product::factory()->create([
            'category_id' => $foodCategory->id,
            'user_id' => $user->id,
            'status' => 'approved',
            'name' => 'Apple' // Food
        ]);

        $otherProduct = Product::factory()->create([
            'category_id' => $otherCategory->id,
            'user_id' => $user->id,
            'status' => 'approved',
            'name' => 'Shirt' // Not Food
        ]);

        $response = $this->getJson('/api/v1/products/store-finds');

        $response->assertStatus(200)
            ->assertJsonFragment(['name' => 'Shirt'])
            ->assertJsonMissing(['name' => 'Apple']);
    }
}
