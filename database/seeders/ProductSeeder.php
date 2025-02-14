<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'id' => 1,
            'title' => 'Pantalla',
            'price' => '20000.5',
            'description' => 'Tv Samsung 55 Pulgadas 4K Ultra',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'id' => 2,
            'title' => 'Mochila',
            'price' => '474.35',
            'description' => 'Mochila deportiva',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'id' => 3,
            'title' => 'Chamarra',
            'price' => '300.40',
            'description' => 'Color azul, talla CH',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
