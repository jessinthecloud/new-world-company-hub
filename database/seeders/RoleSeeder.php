<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->insert([
            [
                'name' => 'Super Admin',
                'guard_name' => 'Super Admin',
                'team_id' => 0,
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Company Governor',
                'guard_name' => 'Company Governor',
                'team_id' => 1, //Company::where('id', 1)->first(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Company Officer',
                'guard_name' => 'Company Officer',
                'team_id' => 1, //Company::where('id', 1)->first(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Company Settler',
                'guard_name' => 'Company Settler',
                'team_id' => 1, //Company::where('id', 1)->first(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Player',
                'guard_name' => 'Player',
                'team_id' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
