<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRolesTableSeeder extends Seeder
{

    protected $priority = 1;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_roles')->insert([
            'role_name' => 'Admin',
            'description' => 'Administrator role',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('user_roles')->insert([
            'role_name' => 'Doctor',
            'description' => 'Doctor role',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
