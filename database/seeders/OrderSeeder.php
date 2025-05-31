<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        Order::insert([
            [
                'id' => 1,
                'order_date' => '2020-07-05',
                'order_number' => 5,
                'customer_id' => 1,
                'total_amount' => 1000,
            ],
            [
                'id' => 2,
                'order_date' => '2020-08-14',
                'order_number' => 8,
                'customer_id' => 2,
                'total_amount' => 800,
            ],
        ]);
    }
}
