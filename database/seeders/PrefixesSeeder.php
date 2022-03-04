<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PrefixesSeeder extends Seeder
{
    public function run()
    {
    
        
        $prefixes = [ 'Abyssal', 'Electrified', 'Empowered', 'Ignited', 'Frozen', 'Arboreal', 'Brash', 'Opportunistic', 'Vengeful', 'Exhilarating', 'Cruel', 'Scheming', 'Rallying', 'Fireproof', 'Insulated', 'Iceproof', 'Burnished', 'Padded', 'Tempered', 'Reinforced', 'Primeval', 'Imbued', 'Spectral', ];

        $upsert = [];
        foreach($prefixes as $name){
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
