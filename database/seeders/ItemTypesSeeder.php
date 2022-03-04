<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemTypesSeeder extends Seeder
{
    public function run()
    {
        DB::table('item_types')->upsert([
           [
               'name' => 'Weapon',
               'slug' => 'weapon',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Armor',
               'slug' => 'armor',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Consumable',
               'slug' => 'consumable',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Resource',
               'slug' => 'resource',
               'created_at' => now(),
               'updated_at' => now(),
           ],
       ], ['slug']);
    }
}
