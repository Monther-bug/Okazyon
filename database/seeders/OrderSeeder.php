<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create a buyer
        $buyer = User::firstOrCreate(
            ['phone_number' => '0911111111'],
            [
                'first_name' => 'Buyer',
                'last_name' => 'Test',
                'password' => bcrypt('password'),
                'type' => 'buyer',
                'is_verified' => true,
            ]
        );

        // Get the seller's products
        $seller = User::where('phone_number', '0913519105')->first();
        
        if (!$seller) {
            $this->command->error('Seller not found! Please create a seller first.');
            return;
        }

        $products = Product::where('user_id', $seller->id)->get();

        if ($products->isEmpty()) {
            $this->command->error('No products found for this seller!');
            return;
        }

        // Create test orders
        foreach (range(1, 3) as $i) {
            $order = Order::create([
                'buyer_id' => $buyer->id,
                'total_amount' => 0, // Will calculate
                'delivery_address' => "Test Address {$i}, City, Country",
                'status' => ['pending', 'processing', 'delivered'][array_rand(['pending', 'processing', 'delivered'])],
            ]);

            $total = 0;
            
            // Add 1-3 random products to the order
            $orderProducts = $products->random(min(3, $products->count()));
            
            foreach ($orderProducts as $product) {
                $quantity = rand(1, 3);
                $price = $product->discounted_price ?? $product->price;
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $total += $price * $quantity;
            }

            $order->update(['total_amount' => $total]);

            $this->command->info("Created order #{$order->id} with {$orderProducts->count()} products - Total: \${$total}");
        }
    }
}
