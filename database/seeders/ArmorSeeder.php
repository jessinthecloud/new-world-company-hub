<?php

namespace Database\Seeders;

use App\Models\Armor;
use App\Models\Company;
use Illuminate\Database\Seeder;

class ArmorSeeder extends Seeder
{
    public function run()
    {        
        // create from weapons
        // adding ->count(10) does not query for baseweapon again
        // and I dont feel like figuring that out with sequences 
        for($i=0;$i<=20;$i++){
            Armor::factory()
                ->fromBase()
                ->for(Company::all()->random())
                ->create();
        }
        
        // custom
        Armor::factory()
            ->count(5)
            ->for(Company::all()->random())
            ->create();
    }
}
