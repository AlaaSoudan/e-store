<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::insert([
            ['id' => 1, 'product_name' => 'Chai', 'supplier_id' => 1, 'unit_price' => 150],
            ['id' => 2, 'product_name' => 'Rice', 'supplier_id' => 1, 'unit_price' => 300],
            ['id' => 3, 'product_name' => 'Sugar', 'supplier_id' => 2, 'unit_price' => 250],
            ['id' => 4, 'product_name' => 'Biscuit', 'supplier_id' => 3, 'unit_price' => 500],
        ]);
    }
}
