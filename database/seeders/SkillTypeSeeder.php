<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('skill_types')->upsert([
           [
               'name' => 'Crafting',
               'slug' => 'crafting',
               'order' => 10,
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Refining',
               'slug' => 'refining',
               'order' => 20,
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Gathering',
               'slug' => 'gathering',
               'order' => 30,
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Weapon Mastery',
               'slug' => 'weapon-mastery',
               'order' => 40,
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
        ], ['slug']);
    }
}
