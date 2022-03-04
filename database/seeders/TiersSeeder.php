<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TiersSeeder extends Seeder
{
    public function run()
    {
        DB::table('tiers')->upsert([
           [
               'name' => 'Tier 1',
               'number' => 1,
               'code' => 'T1',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Tier 2',
               'number' => 2,
               'code' => 'T2',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Tier 3',
               'number' => 3,
               'code' => 'T3',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Tier 4',
               'number' => 4,
               'code' => 'T4',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Tier 5',
               'number' => 5,
               'code' => 'T5',
               'created_at' => now(),
               'updated_at' => now(),
           ],
       ], ['name']);
    }
}
