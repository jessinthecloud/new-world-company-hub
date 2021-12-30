<?php

namespace Database\Seeders;

use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class WeaponSeeder extends Seeder
{
    public function run()
    {
        /*Weapon::factory()
            ->count(10)
            ->state(new Sequence(
                fn ($sequence) => [
                        'weapon_type_id' => WeaponType::all()->random(),
                    ],
                )
            )
            ->create();*/

        // simplify for now
        return [
            [ // 1
                'name'        => 'Sword and Shield',
                'description' => '',
                'skill_id'    => 18,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 2
                'name'        => 'Rapier',
                'description' => '',
                'skill_id'    => 19,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 3
                'name'        => 'Hatchet',
                'description' => '',
                'skill_id'    => 20,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 4
                'name'        => 'Spear',
                'description' => '',
                'skill_id'    => 21,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [// 5
                'name'        => 'Great Axe',
                'description' => '',
                'skill_id'    => 22,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 6 
                'name'        => 'War Hammer',
                'description' => '',
                'skill_id'    => 23,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 7
                'name'        => 'Bow',
                'description' => '',
                'skill_id'    => 24,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 8
                'name'        => 'Musket',
                'description' => '',
                'skill_id'    => 25,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 9
                'name'        => 'Fire Staff',
                'description' => '',
                'skill_id'    => 26,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 10
                'name'        => 'Life Staff',
                'description' => '',
                'skill_id'    => 27,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 11
                'name'        => 'Ice Gauntlet',
                'description' => '',
                'skill_id'    => 28,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [ // 12
                'name'        => 'Void Gauntlet',
                'description' => '',
                'skill_id'    => 29,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];
    }
}
