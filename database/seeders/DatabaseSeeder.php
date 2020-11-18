<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role' => 'Administrator',
            'description' => 'Super user',
        ]);

        DB::table('users')->insert([
            'role_id' => '1',
            'firstname' => 'Haris',
            'lastname' => 'Lagrosa',
            'email' => 'harislagrosa721@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
