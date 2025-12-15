<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;

class TestOrderSeeder extends Seeder
{
    public function run()
    {
        $seller = User::first();
        if (!$seller) {
            $seller = User::factory()->create([
                'name' => 'Seller User',
                'email' => 'seller@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        $category = Category::first();
        if (!$category) {
            $category = Category::create(['name' => 'Test Category', 'slug' => 'test-cat']);
        }

        $product = $seller->products()->first();
        if (!$product) {
            $product = $seller->products()->create([
                'name' => 'Test Product for Order',
                'description' => 'Created via seeder for testing orders',
                'price' => 150.00,
                'category_id' => $category->id,
                'images' => [],
                'status' => 'approved'
            ]);
        }

        $order = Order::create([
            'buyer_id' => $seller->id, // Buyer is same as seller for ease
            'total_amount' => 450.00,
            'delivery_address' => '456 Order Lane, Tripoli',
            'status' => 'pending'
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 3,
            'price' => 150.00
        ]);

        $this->command->info("Order {$order->id} created with 3x {$product->name}!");
    }
}
