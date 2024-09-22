<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'cat_id' => 1,
                'serialNumber' => Str::random(10) . '-' . Str::random(10),
                'yearOfRelease' => '2022-01-15',
                'brand' => 'ChromeCo',
                'model' => 'Chromex 2000',
                'price' => 10,
                'quantity' => 10,
            ],
            [
                'cat_id' => 1,
                'serialNumber' => Str::random(10) . '-' . Str::random(10),
                'yearOfRelease' => '2022-03-20',
                'brand' => 'NickelWorks',
                'model' => 'N-Plater Pro',
                'price' => 10,
                'quantity' => 55,
            ],
            [
                'cat_id' => 3,
                'serialNumber' => Str::random(10) . '-' . Str::random(10),
                'yearOfRelease' => '2022-05-10',
                'brand' => 'GoldTouch',
                'model' => 'GoldMaster 5000',
                'price' => 10,
                'quantity' => 3,
            ],
        ];


        DB::table('products')->insert($products);

    }
}
