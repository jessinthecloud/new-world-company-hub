<?php

namespace Database\Seeders;

use App\Models\Companies\Company;
use App\Models\Items\BaseWeapon;
use App\Models\Items\Weapon;
use Illuminate\Database\Seeder;

class WeaponSeeder extends Seeder
{
    public function run()
    {   
        $baseWeapons = BaseWeapon::whereNotIn('slug', 
            Weapon::all()->pluck('slug')->all() 
        )->has('perks')->inRandomOrder()->take(10)->get();
        
        $companies = Company::inRandomOrder()->take(5)->get();
             
        // create from weapons
        for($i=0;$i<=20;$i++){
            // adding ->count(10) does not query for baseWeapon again
            // and I dont feel like figuring that out with sequences 
            Weapon::factory()
                ->fromBase($baseWeapons->shift())
                ->for($companies->first())
                ->create();
            
            /*// custom
            Weapon::factory()
                ->for($companies->shift())
                ->hasAttached($baseWeapons->shift()->perks)
                ->create();*/
        } // end for
        
            // custom
            Weapon::factory()
                ->count(5)
                ->for($companies->first())
                ->hasAttached($baseWeapons->shift()->perks)
                ->create();
    }
}
