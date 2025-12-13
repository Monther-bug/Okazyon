<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DashboardTestDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Creating enhanced test data for ALL sellers...');

        // Always ensure Demo Seller exists
        $demoSeller = User::firstOrCreate(
            ['phone_number' => '0910000000'],
            [
                'first_name' => 'Demo',
                'last_name' => 'Seller',
                'password' => bcrypt('password'),
                'type' => 'seller',
                'status' => 'active',
                'is_verified' => true,
            ]
        );

        if (!$demoSeller->hasRole('seller')) {
            $demoSeller->assignRole('seller');
        }

        // Get all sellers including the new demo one
        $sellers = User::role('seller')->get();

        if ($sellers->isEmpty()) {
            // Should not happen now
            $this->command->error('No sellers found!');
        }

        // Get or create generic buyer
        $buyers = [];
        for ($i = 1; $i <= 5; $i++) {
            $buyers[] = User::firstOrCreate(
                ['phone_number' => "091111111{$i}"],
                [
                    'first_name' => 'Buyer',
                    'last_name' => (string) $i,
                    'password' => bcrypt('password'),
                    'type' => 'buyer',
                    'status' => 'active',
                    'is_verified' => true,
                ]
            );
        }

        foreach ($sellers as $seller) {
            $this->command->info("Processing seller: {$seller->name} ({$seller->id})");

            // 1. Ensure Seller has Products
            $products = Product::where('user_id', $seller->id)->get();
            if ($products->isEmpty()) {
                $this->command->info("  - Creating dummy products...");

                $category = \App\Models\Category::firstOrCreate(
                    ['name' => 'Demo Category'],
                    ['image' => 'categories/default.png', 'is_active' => true]
                );

                for ($k = 1; $k <= 5; $k++) {
                    Product::create([
                        'user_id' => $seller->id,
                        'category_id' => $category->id,
                        'name' => "Demo Product {$k}",
                        'description' => "This is a description for demo product {$k}",
                        'price' => rand(10, 100),
                        'discounted_price' => rand(5, 9),
                        'status' => 'approved',
                        'images' => [],
                    ]);
                }

                $products = Product::where('user_id', $seller->id)->get();
            }

            // 2. Create Orders
            $this->command->info("  - Creating orders throughout the year...");
            $statuses = ['pending', 'processing', 'delivered', 'delivered', 'cancelled'];

            for ($month = 1; $month <= 12; $month++) {
                // 1-3 orders per month per seller
                $ordersThisMonth = rand(1, 3);

                for ($i = 0; $i < $ordersThisMonth; $i++) {
                    $buyer = $buyers[array_rand($buyers)];
                    $status = $statuses[array_rand($statuses)];
                    $date = now()->subMonths(12 - $month)->setDay(rand(1, 28));

                    // Select 1-3 random products from THIS seller
                    $orderProducts = $products->random(rand(1, min(3, $products->count())));

                    $totalAmount = 0;
                    $orderItemsData = [];

                    foreach ($orderProducts as $product) {
                        $quantity = rand(1, 3);
                        $price = $product->discounted_price ?? $product->price;
                        $totalAmount += $price * $quantity; // Note: In a real multi-vendor cart, order total would be sum of all, but here we simplify

                        $orderItemsData[] = [
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'price' => $price,
                        ];
                    }

                    // Create Order (Simulating an order containing only this seller's items for simplicity, or representing a sub-order)
                    $order = Order::create([
                        'buyer_id' => $buyer->id,
                        'total_amount' => $totalAmount,
                        'status' => $status,
                        'delivery_address' => '123 Fake St, Cityville',
                        'created_at' => $date,
                        'updated_at' => $date,
                    ]);

                    foreach ($orderItemsData as $itemData) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $itemData['product_id'],
                            'quantity' => $itemData['quantity'],
                            'price' => $itemData['price'],
                            'created_at' => $date,
                            'updated_at' => $date,
                        ]);
                    }
                }
            }
        }

        $this->command->info('✓ Seeded data for all sellers successfully!');
    }
}
