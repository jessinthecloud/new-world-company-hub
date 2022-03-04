<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerkTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('perk_types')->upsert([
           [
               'name' => 'Attribute',
               'slug' => 'attribute',
               'json_key' => 'Inherent',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Gem',
               'slug' => 'gem',
               'json_key' => 'Gem',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Perk',
               'slug' => 'perk',
               'json_key' => 'Generated',
               'created_at' => now(),
               'updated_at' => now(),
           ],
       ], ['name']);
    }
}
