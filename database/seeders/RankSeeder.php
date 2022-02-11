<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankSeeder extends Seeder
{
    public function run()
    {
        DB::table('ranks')->upsert([
           [
               'name' => 'Governor',
               'description' => 'Company Owner',
               'order' => 1,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Consul',
               'description' => '',
               'order' => 2,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Officer',
               'description' => '',
               'order' => 3,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Settler',
               'description' => '',
               'order' => 4,
               'created_at' => now(),
               'updated_at' => now(),
           ],
       ], ['name']);
    }
}
