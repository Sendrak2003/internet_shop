<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrdersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [
            [
                'product_id' => 3,
                'user_id' => 1,
                'orderDate' => '2022-01-01',
                'deliveryDate' => '2022-01-10',
                'price' => 220.00,
                'quantityProduct' => 22,
                'status_id' => 1,
            ],
            [
                'product_id' => 1,
                'user_id' => 1,
                'orderDate' => '2022-01-01',
                'deliveryDate' => '2022-01-10',
                'price' => 50.00,
                'quantityProduct' => 5,
                'status_id' => 4,
            ],
        ];
        DB::table('orders')->insert($orders);
    }
}
