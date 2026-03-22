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
            ['name' => 'Laptop', 'price' => 89900],
            ['name' => 'Wireless Mouse', 'price' => 2990],
            ['name' => 'Keyboard', 'price' => 4990],
            ['name' => 'Monitor', 'price' => 24900],
            ['name' => 'USB-C Hub', 'price' => 3490],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
