<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'rh1',
            'last_name' => 'rh1',
            'second_last_name' => 'rh1',
            'email' => 'rh1@example.com',
            'password' => Hash::make('rh1password'),
            'role' => 4,
            'active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'id' => 2,
            'name' => 'planning1',
            'last_name' => 'planning1',
            'second_last_name' => 'planning1',
            'email' => 'planning1@example.com',
            'password' => Hash::make('planning1password'),
            'role' => 2,
            'active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'id' => 3,
            'name' => 'developer1',
            'last_name' => 'developer1',
            'second_last_name' => 'developer1',
            'email' => 'developer1@example.com',
            'password' => Hash::make('developer1password'),
            'role' => 1,
            'active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'id' => 4,
            'name' => 'developer2',
            'last_name' => 'developer2',
            'second_last_name' => 'developer2',
            'email' => 'developer2@example.com',
            'password' => Hash::make('developer2password'),
            'role' => 1,
            'active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'id' => 5,
            'name' => 'developer3',
            'last_name' => 'developer3',
            'second_last_name' => 'developer3',
            'email' => 'developer3@example.com',
            'password' => Hash::make('developer3password'),
            'role' => 1,
            'active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'id' => 6,
            'name' => 'Tester1',
            'last_name' => 'Tester1',
            'second_last_name' => 'Tester1',
            'email' => 'tester1@example.com',
            'password' => Hash::make('tester1password'),
            'role' => 3,
            'active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

        DB::table('users')->insert([
            'id' => 7,
            'name' => 'Tester2',
            'last_name' => 'Tester2',
            'second_last_name' => 'Tester2',
            'email' => 'tester2@example.com',
            'password' => Hash::make('tester2password'),
            'role' => 3,
            'active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);

    }
}
