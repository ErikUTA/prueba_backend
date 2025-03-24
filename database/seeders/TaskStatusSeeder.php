<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('task_status')->insert([
            'id' => 1,
            'name' => 'En proceso',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('task_status')->insert([
            'id' => 2,
            'name' => 'Finalizada',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('task_status')->insert([
            'id' => 3,
            'name' => 'En pruebas',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('task_status')->insert([
            'id' => 4,
            'name' => 'Bug',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('task_status')->insert([
            'id' => 5,
            'name' => 'En espera de asignacion',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
