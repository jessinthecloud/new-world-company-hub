<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeaponTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('weapon_types')->insert([
            [ // 1
            'name' => 'Sword and Shield',
            'slug' => 'sword-and-shield',
            'description' => '',
            'skill_id' => 18,
            'created_at' => now(),
            'updated_at' => now(),
            ],
           [// 2
           'name' => 'Rapier',
           'slug' => 'rapier',
           'description' => '',
           'skill_id' => 19,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [// 3
           'name' => 'Hatchet',
           'slug' => 'hatchet',
           'description' => '',
           'skill_id' => 20,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [// 4
           'name' => 'Spear',
           'slug' => 'spear',
           'description' => '',
           'skill_id' => 21,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [// 5
           'name' => 'Great Axe',
           'slug' => 'great-axe',
           'description' => '',
           'skill_id' => 22,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [ // 6 
           'name' => 'War Hammer',
           'slug' => 'war-hammer',
           'description' => '',
           'skill_id' => 23,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [ // 7
           'name' => 'Bow',
           'slug' => 'bow',
           'description' => '',
           'skill_id' => 24,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [ // 8
           'name' => 'Musket',
           'slug' => 'musket',
           'description' => '',
           'skill_id' => 25,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [ // 9
           'name' => 'Fire Staff',
           'slug' => 'fire-staff',
           'description' => '',
           'skill_id' => 26,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [ // 10
           'name' => 'Life Staff',
           'slug' => 'life-staff',
           'description' => '',
           'skill_id' => 27,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [ // 11
           'name' => 'Ice Gauntlet',
           'slug' => 'ice-gauntlet',
           'description' => '',
           'skill_id' => 28,
           'created_at' => now(),
           'updated_at' => now(),
           ],
           [ // 12
           'name' => 'Void Gauntlet',
           'slug' => 'void-gauntlet',
           'description' => '',
           'skill_id' => 29,
           'created_at' => now(),
           'updated_at' => now(),
           ],
       ]);
    }
}
