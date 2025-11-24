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
        $this->command->info('Creating enhanced test data for seller dashboard...');
        
        // Get seller user
        $seller = User::where('phone_number', '0913519105')->first();
        
        if (!$seller) {
            $this->command->error('Seller user not found!');
            return;
        }
        
        // Get seller's products
        $products = Product::where('user_id', $seller->id)->get();
        
        if ($products->isEmpty()) {
            $this->command->error('No products found for seller!');
            return;
        }
        
        // Get or create buyer
        $buyer = User::firstOrCreate(
            ['phone_number' => '0911111111'],
            [
                'first_name' => 'Test',
                'last_name' => 'Buyer',
                'password' => bcrypt('password'),
                'type' => 'buyer',
                'status' => 'active',
                'is_verified' => true,
            ]
        );
        
        // Create more buyers for variety
        $buyers = [$buyer];
        for ($i = 2; $i <= 5; $i++) {
            $buyers[] = User::firstOrCreate(
                ['phone_number' => '091111111' . $i],
                [
                    'first_name' => 'Buyer',
                    'last_name' => $i,
                    'password' => bcrypt('password'),
                    'type' => 'buyer',
                    'status' => 'active',
                    'is_verified' => true,
                ]
            );
        }
        
        $this->command->info('Creating orders throughout the year...');
        
        // Create orders spread across the year with different statuses
        $statuses = ['pending', 'processing', 'delivered', 'delivered', 'delivered']; // More delivered
        $orderCount = 0;
        
        for ($month = 1; $month <= 11; $month++) {
            // Create 2-5 orders per month
            $ordersThisMonth = rand(2, 5);
            
            for ($i = 0; $i < $ordersThisMonth; $i++) {
                $buyer = $buyers[array_rand($buyers)];
                $status = $statuses[array_rand($statuses)];
                
                // Random date in the month
                $date = now()->setMonth($month)->setDay(rand(1, 28))->setHour(rand(8, 20));
                
                // Select 1-3 random products
                $orderProducts = $products->random(rand(1, min(3, $products->count())));
                
                $totalAmount = 0;
                $orderItemsData = [];
                
                foreach ($orderProducts as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->discounted_price ?? $product->price;
                    $totalAmount += $price * $quantity;
                    
                    $orderItemsData[] = [
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ];
                }
                
                // Create order
                $order = Order::create([
                    'buyer_id' => $buyer->id,
                    'total_amount' => $totalAmount,
                    'status' => $status,
                    'delivery_address' => 'Test Address, City',
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
                
                // Create order items
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
                
                $orderCount++;
            }
        }
        
        $this->command->info("✓ Created {$orderCount} orders across the year");
        
        // Summary
        $this->command->newLine();
        $this->command->info('Dashboard Test Data Summary:');
        $this->command->info('-----------------------------');
        $this->command->info('Pending orders: ' . Order::whereHas('items.product', fn($q) => $q->where('user_id', $seller->id))->where('status', 'pending')->count());
        $this->command->info('Processing orders: ' . Order::whereHas('items.product', fn($q) => $q->where('user_id', $seller->id))->where('status', 'processing')->count());
        $this->command->info('Delivered orders: ' . Order::whereHas('items.product', fn($q) => $q->where('user_id', $seller->id))->where('status', 'delivered')->count());
        $this->command->info('Cancelled orders: ' . Order::whereHas('items.product', fn($q) => $q->where('user_id', $seller->id))->where('status', 'cancelled')->count());
        
        $totalRevenue = \DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('products.user_id', $seller->id)
            ->where('orders.status', 'delivered')
            ->sum(\DB::raw('order_items.price * order_items.quantity'));
        
        $this->command->info('Total Revenue: $' . number_format($totalRevenue, 2));
        $this->command->newLine();
        $this->command->info('✓ Dashboard test data created successfully!');
    }
}
