<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Weapon;
use Illuminate\Database\Seeder;

class WeaponSeeder extends Seeder
{
    public function run()
    {        
        // create from weapons
        // adding ->count(10) does not query for baseweapon again
        // and I dont feel like figuring that out with sequences 
        for($i=0;$i<=20;$i++){
            Weapon::factory()
                ->fromBase()
                ->create();
        }
        
        // custom
        Weapon::factory()
            ->count(5)
            ->create();
    }
}
