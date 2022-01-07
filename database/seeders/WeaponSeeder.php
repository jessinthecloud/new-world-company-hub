<?php

namespace Database\Seeders;

use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeaponSeeder extends Seeder
{
    public function run()
    {
        /*Weapon::factory()
            ->count(10)
            ->state(new Sequence(
                fn ($sequence) => [
                        'weapon_type_id' => WeaponType::all()->random(),
                    (,
                )
            )
            ->create();*/

        // simplify for now
        DB::table('weapons')->insert( [
            [ // 1
                'name'        => 'Sword and Shield',
                'slug'        => 'sword-and-shield',
                'description' => '',
                'weapon_type_id' => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 2
                'name'        => 'Rapier',
                'slug'        => 'rapier',
                'description' => '',
                'weapon_type_id' => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 3
                'name'        => 'Hatchet',
                'slug'        => 'hatchet',
                'description' => '',
                'weapon_type_id' => 3,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 4
                'name'        => 'Spear',
                'slug'        => 'spear',
                'description' => '',
                'weapon_type_id' => 4,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 5
                'name'        => 'Great Axe',
                'slug'        => 'great-axe',
                'description' => '',
                'weapon_type_id' => 5,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 6 
                'name'        => 'War Hammer',
                'slug'        => 'war-hammer',
                'description' => '',
                'weapon_type_id' => 6,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 7
                'name'        => 'Bow',
                'slug'        => 'bow',
                'description' => '',
                'weapon_type_id' => 7,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 8
                'name'        => 'Musket',
                'slug'        => 'musket',
                'description' => '',
                'weapon_type_id' => 8,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 9
                'name'        => 'Fire Staff',
                'slug'        => 'fire-staff',
                'description' => '',
                'weapon_type_id' => 9,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 10
                'name'        => 'Life Staff',
                'slug'        => 'life-staff',
                'description' => '',
                'weapon_type_id' => 10,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 11
                'name'        => 'Ice Gauntlet',
                'slug'        => 'ice-gauntlet',
                'description' => '',
                'weapon_type_id' => 11,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 12
                'name'        => 'Void Gauntlet',
                'slug'        => 'void-gauntlet',
                'description' => '',
                'weapon_type_id' => 12,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 9
                'name'        => 'Firestaff',
                'slug'        => 'firestaff',
                'description' => '',
                'weapon_type_id' => 9,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 10
                'name'        => 'Lifestaff',
                'slug'        => 'lifestaff',
                'description' => '',
                'weapon_type_id' => 10,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
