<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Coffee',
                'price' => 120,
                'stock' => 20,
                'available' => true,
                'description' => 'Freshly brewed coffee.',
            ],
            [
                'name' => 'Chocolate',
                'price' => 80,
                'stock' => 15,
                'available' => true,
                'description' => 'Sweet chocolate snack.',
            ],
            [
                'name' => 'Fries',
                'price' => 75,
                'stock' => 30,
                'available' => true,
                'description' => 'Crispy potato fries.',
            ],
            [
                'name' => 'Burger',
                'price' => 150,
                'stock' => 25,
                'available' => true,
                'description' => 'Burger with fresh vegetables.',
            ],
            [
                'name' => 'Pizza',
                'price' => 250,
                'stock' => 10,
                'available' => true,
                'description' => null,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
