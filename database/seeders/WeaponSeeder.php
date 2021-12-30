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
                'description' => '',
                'weapon_type_id' => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 2
                'name'        => 'Rapier',
                'description' => '',
                'weapon_type_id' => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 3
                'name'        => 'Hatchet',
                'description' => '',
                'weapon_type_id' => 3,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 4
                'name'        => 'Spear',
                'description' => '',
                'weapon_type_id' => 4,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 5
                'name'        => 'Great Axe',
                'description' => '',
                'weapon_type_id' => 5,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 6 
                'name'        => 'War Hammer',
                'description' => '',
                'weapon_type_id' => 6,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 7
                'name'        => 'Bow',
                'description' => '',
                'weapon_type_id' => 7,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 8
                'name'        => 'Musket',
                'description' => '',
                'weapon_type_id' => 8,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 9
                'name'        => 'Fire Staff',
                'description' => '',
                'weapon_type_id' => 9,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 10
                'name'        => 'Life Staff',
                'description' => '',
                'weapon_type_id' => 10,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 11
                'name'        => 'Ice Gauntlet',
                'description' => '',
                'weapon_type_id' => 11,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 12
                'name'        => 'Void Gauntlet',
                'description' => '',
                'weapon_type_id' => 12,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 9
                'name'        => 'Firestaff',
                'description' => '',
                'weapon_type_id' => 9,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 10
                'name'        => 'Lifestaff',
                'description' => '',
                'weapon_type_id' => 10,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
