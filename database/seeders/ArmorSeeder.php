<?php

namespace Database\Seeders;

use App\Models\Armor;
use Illuminate\Database\Seeder;

class ArmorSeeder extends Seeder
{
    public function run()
    {        
        // create from weapons
        // adding ->count(10) does not query for baseweapon again
        // and I dont feel like figuring that out with sequences 
        for($i=0;$i<=10;$i++){
            Armor::factory()->fromBase()->create();
        }
        
        // custom
        Armor::factory()
            ->count(5)
            ->create();
    }
}
