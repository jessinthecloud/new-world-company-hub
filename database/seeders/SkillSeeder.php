<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillSeeder extends Seeder
{
    public function run()
    {
        DB::table('skills')->upsert([
           [
           'name' => 'Weaponsmithing',
           'slug' => 'weaponsmithing',
           'description' => '',
           'order' => 10,
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Armoring',
           'slug' => 'armoring',
           'description' => '',
           'order' => 20,
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Engineering',
           'slug' => 'engineering',
           'description' => '',
           'order' => 30,
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Jewelcrafting',
           'slug' => 'jewelcrafting',
           'description' => '',
           'order' => 40,
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Arcana',
           'slug' => 'arcana',
           'description' => '',
           'order' => 50,
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Cooking',
           'slug' => 'cooking',
           'description' => '',
           'order' => 60,
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Furnishing',
           'slug' => 'furnishing',
           'description' => '',
           'order' => 70,
           'skill_type_id' => 1,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           // refining
           [
           'name' => 'Smelting',
           'slug' => 'smelting',
           'description' => '',
           'order' => 80,
           'skill_type_id' => 2,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Woodworking',
           'slug' => 'woodworking',
           'description' => '',
           'order' => 90,
           'skill_type_id' => 2,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Leatherworking',
           'slug' => 'leatherworking',
           'description' => '',
           'order' => 100,
           'skill_type_id' => 2,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Weaving',
           'slug' => 'weaving',
           'description' => '',
           'order' => 110,
           'skill_type_id' => 2,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Stonecutting',
           'slug' => 'stonecutting',
           'description' => '',
           'order' => 120,
           'skill_type_id' => 2,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           // gathering
           [
           'name' => 'Logging',
           'slug' => 'logging',
           'description' => '',
           'order' => 130,
           'skill_type_id' => 3,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Mining',
           'slug' => 'mining',
           'description' => '',
           'order' => 140,
           'skill_type_id' => 3,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Fishing',
           'slug' => 'fishing',
           'description' => '',
           'order' => 150,
           'skill_type_id' => 3,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Harvesting',
           'slug' => 'harvesting',
           'description' => '',
           'order' => 160,
           'skill_type_id' => 3,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Tracking and Skinning',
           'slug' => 'tracking-and-skinning',
           'description' => '',
           'order' => 170,
           'skill_type_id' => 3,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           // weapon mastery
           [
           'name' => 'Sword and Shield',
           'slug' => 'sword-and-shield',
           'description' => '',
           'order' => 180,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Rapier',
           'slug' => 'rapier',
           'description' => '',
           'order' => 190,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Hatchet',
           'slug' => 'hatchet',
           'description' => '',
           'order' => 200,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Spear',
           'slug' => 'spear',
           'description' => '',
           'order' => 210,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Great Axe',
           'slug' => 'great-axe',
           'description' => '',
           'order' => 220,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'War Hammer',
           'slug' => 'war-hammer',
           'description' => '',
           'order' => 230,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Bow',
           'slug' => 'bow',
           'description' => '',
           'order' => 240,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Musket',
           'slug' => 'musket',
           'description' => '',
           'order' => 250,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Fire Staff',
           'slug' => 'fire-staff',
           'description' => '',
           'order' => 260,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Life Staff',
           'slug' => 'life-staff',
           'description' => '',
           'order' => 270,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Ice Gauntlet',
           'slug' => 'ice-gauntlet',
           'description' => '',
           'order' => 280,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [
           'name' => 'Void Gauntlet',
           'slug' => 'void-gauntlet',
           'description' => '',
           'order' => 280,
           'skill_type_id' => 4,
           'created_at' => now(),
           'updated_at' => now(),
           ],
       ], ['slug']);
    }
}
