<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class SampleOrdersSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();
        $products = Product::all();

        if (!$user || $products->isEmpty()) {
            $this->command->info('No user or products found. Run DatabaseSeeder first.');
            return;
        }

        // Create 10 sample orders over the last 3 months
        for ($i = 0; $i < 10; $i++) {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => rand(500, 5000),
                'status' => ['pending', 'processing', 'shipped', 'delivered'][rand(0, 3)],
                'payment_status' => rand(0, 1) ? 'paid' : 'pending',
                'payment_method' => 'cod',
                'created_at' => now()->subDays(rand(1, 90))
            ]);

            // Add 1-3 items to each order
            $itemCount = rand(1, 3);
            for ($j = 0; $j < $itemCount; $j++) {
                $product = $products->random();
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => rand(1, 3),
                    'price' => $product->price
                ]);
            }
        }

        $this->command->info('Sample orders created successfully!');
    }
}
