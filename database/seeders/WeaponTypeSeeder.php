<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeaponTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('weapon_types')->insert([
            [
            'name' => 'Sword and Shield',
            'description' => '',
            'skill_id' => 18,
            'created_at' => now(),
            'updated_at' => now(),
            ],
           [
           'name' => 'Rapier',
           'description' => '',
           'skill_id' => 19,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Hatchet',
           'description' => '',
           'skill_id' => 20,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Spear',
           'description' => '',
           'skill_id' => 21,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Great Axe',
           'description' => '',
           'skill_id' => 22,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'War Hammer',
           'description' => '',
           'skill_id' => 23,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Bow',
           'description' => '',
           'skill_id' => 24,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Musket',
           'description' => '',
           'skill_id' => 25,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Fire Staff',
           'description' => '',
           'skill_id' => 26,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Life Staff',
           'description' => '',
           'skill_id' => 27,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Ice Gauntlet',
           'description' => '',
           'skill_id' => 28,
           'created_at' => now(),
           'updated_at' => now(),
           ],
       ]);
    }
}
