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
    }
}
