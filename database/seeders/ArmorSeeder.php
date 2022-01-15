<?php

namespace Database\Seeders;

use App\Models\Armor;
use App\Models\BaseArmor;
use App\Models\Company;
use Illuminate\Database\Seeder;

class ArmorSeeder extends Seeder
{
    public function run()
    {        
        $baseArmors = BaseArmor::whereNotIn('slug', 
            Armor::all()->pluck('slug')->all() 
        )->has('perks')->inRandomOrder()->take(10)->get();
        
        $companies = Company::inRandomOrder()->take(5)->get();
       
        // create from weapons
        for($i=0;$i<=20;$i++){
            // adding ->count(10) does not query for baseArmor again
            // and I dont feel like figuring that out with sequences 
            Armor::factory()
                ->fromBase($baseArmors->shift())
                ->for($companies->first())
                ->create();
            
            /*// custom
            Armor::factory()
                ->for($companies->shift())
                ->hasAttached($baseArmors->shift()->perks)
                ->create();*/
        } // end for
        
            // custom
            Armor::factory()
                ->count(5)
                ->for($companies->first())
                ->hasAttached($baseArmors->shift()->perks)
                ->create();

    }
}
