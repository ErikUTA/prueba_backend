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
            'titulo' => 'Pantalla',
            'precio' => '20000.5',
            'descripcion' => 'Tv Samsung 55 Pulgadas 4K Ultra',
            'fk_id_categoria' => '1',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'id' => 2,
            'titulo' => 'Mochila',
            'precio' => '474.35',
            'descripcion' => 'Mochila deportiva',
            'fk_id_categoria' => '2',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('products')->insert([
            'id' => 3,
            'titulo' => 'Chamarra',
            'precio' => '300.40',
            'descripcion' => 'Color azul, talla CH',
            'fk_id_categoria' => '3, 4',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
