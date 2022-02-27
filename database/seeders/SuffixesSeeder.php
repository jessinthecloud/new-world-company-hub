<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SuffixesSeeder extends Seeder
{
    public function run()
    {
    
        
        $suffixes = ['of the Soldier', 'of the Fighter', 'of the Spellsword', 'of the Barbarian', 'of the Monk', 'of the Cavalier', 'of the Ranger', 'of the Assassin', 'of the Brigand', 'of the Duelist', 'of the Battlemage', 'of the Trickster', 'of the Scholar', 'of the Occultist', 'of the Mage', 'of the Knight', 'of the Warden', 'of the Druid', 'of the Sentry', 'of the Nomad', 'of the Zealot', 'of the Artificer', 'of the Priest', 'of the Cleric', 'of the Sage',];

        $upsert = [];
        foreach($suffixes as $name){
            $upsert []= [
               'name' => $name,
               'slug' => Str::slug($name),
               'created_at' => now(),
               'updated_at' => now(),
            ]; 
        }

        DB::table('prefixes')->upsert($upsert, ['slug']);
    }
}
