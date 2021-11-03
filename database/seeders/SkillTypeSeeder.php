<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('skill_types')->insert([
           [
               'name' => 'Crafting',
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Refining',
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Gathering',
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Weapon Mastery',
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
        ]);
    }
}
