<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Ashvattha Classic Tea',
                'description' => 'Sacred leaf wellness tea. Naturally calming, traditionally respected, designed for daily rituals. 100g premium blend.',
                'price' => 29.99,
                'stock' => 100,
                'image' => 'assets/img/product.jpeg'
            ],
            [
                'name' => 'Herbal Elixir',
                'description' => 'Daily vitality blend crafted from ancient botanical wisdom. Supports respiratory health and digestion. 250ml.',
                'price' => 39.99,
                'stock' => 75,
                'image' => 'assets/img/ritual-1.jpeg'
            ],
            [
                'name' => 'Botanical Tonic',
                'description' => 'Restorative formula combining time-tested herbs for holistic wellness. Water-based extraction. 200ml.',
                'price' => 44.99,
                'stock' => 60,
                'image' => 'assets/img/ritual-2.jpeg'
            ],
            [
                'name' => 'Wellness Drops',
                'description' => 'Concentrated essence of pure botanicals. Third-party tested for purity and potency. 50ml.',
                'price' => 34.99,
                'stock' => 80,
                'image' => 'assets/img/ritual-3.jpeg'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
