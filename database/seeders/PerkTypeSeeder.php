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
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Gem',
               'slug' => 'gem',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Perk',
               'slug' => 'perk',
               'created_at' => now(),
               'updated_at' => now(),
           ],
       ], ['name']);
    }
}
