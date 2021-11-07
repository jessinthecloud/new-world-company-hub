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
        Weapon::factory()
            ->count(10)
            ->state(new Sequence(
                fn ($sequence) => [
                        'weapon_type_id' => WeaponType::all()->random(),
                    ],
                )
            )
            ->create();
    }
}
