<?php

namespace Database\Seeders;

use App\Models\Categories;
use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DufultDetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Chrome plating'],
            ['name' => 'Nickel plating'],
            ['name' => 'Gilding'],

        ];

        // Вставка категорий в таблицу 'categories'
        DB::table('categories')->insert($categories);

        $statuses = [null,'Принято', 'Завершено', 'Отправлено', 'В процессе'];
        foreach ($statuses as $status) {
            DB::table('statuses')->insert([
                'name' => $status,
            ]);
        }

        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'user'],
        ]);

    }
}
