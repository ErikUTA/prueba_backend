<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('status')->insert([
            'id' => 1,
            'name' => 'Desarrollo',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 2,
            'name' => 'Finalizado',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 3,
            'name' => 'Cancelado',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 4,
            'name' => 'Pausa',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 5,
            'name' => 'En proceso',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 6,
            'name' => 'Finalizada',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 7,
            'name' => 'En pruebas',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 8,
            'name' => 'Bug',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('status')->insert([
            'id' => 9,
            'name' => 'En espera de asignacion',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
