<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Loadout;
use App\Models\BaseWeapon;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class LoadoutSeeder extends Seeder
{
    public function run()
    {
        Loadout::factory()
            ->count(10)
            /*->for(Character::all()->random(), 'character')
            ->for(Weapon::factory(), 'main')
            ->for(Weapon::factory(), 'offhand')*/
            ->create();
    }
}
