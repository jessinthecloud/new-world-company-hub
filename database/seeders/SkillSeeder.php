<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    public function run()
    {
        DB::table('skills')->insert([
           [
           'name' => 'Weaponsmithing',
           'description' => '',
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Armoring',
           'description' => '',
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Engineering',
           'description' => '',
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Jewelcrafting',
           'description' => '',
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Arcana',
           'description' => '',
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Cooking',
           'description' => '',
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Furnishing',
           'description' => '',
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           // refining
           [
           'name' => 'Smelting',
           'description' => '',
           'skill_type_id' => 2,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Woodworking',
           'description' => '',
           'skill_type_id' => 2,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Leatherworking',
           'description' => '',
           'skill_type_id' => 2,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Weaving',
           'description' => '',
           'skill_type_id' => 2,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Stonecutting',
           'description' => '',
           'skill_type_id' => 2,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           // gathering
           [
           'name' => 'Logging',
           'description' => '',
           'skill_type_id' => 3,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Mining',
           'description' => '',
           'skill_type_id' => 3,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Fishing',
           'description' => '',
           'skill_type_id' => 3,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Harvesting',
           'description' => '',
           'skill_type_id' => 3,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Skinning',
           'description' => '',
           'skill_type_id' => 3,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           // weapon mastery
           [
           'name' => 'Sword and Shield',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Rapier',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Hatchet',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Spear',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Great Axe',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'War Hammer',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Bow',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Musket',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Fire Staff',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Life Staff',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Ice Gauntlet',
           'description' => '',
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
       ]);
    }
}
