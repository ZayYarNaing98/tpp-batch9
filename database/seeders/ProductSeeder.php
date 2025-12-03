<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Product A',
                'description' => "This is Product A",
                'price' => 1000,
            ],
            [
                'name' => 'Product B',
                'description' => "This is Product B",
                'price' => 2000,
            ],
            [
                'name' => 'Product C',
                'description' => "This is Product C",
                'price' => 3000,
            ],
            [
                'name' => 'Product D',
                'description' => "This is Product D",
                'price' => 4000,
            ],
        ];

        foreach($products as $product)
        {
            Product::create($product);
        }
    }
}
