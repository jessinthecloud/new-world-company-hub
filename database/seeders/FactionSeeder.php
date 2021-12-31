<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FactionSeeder extends Seeder
{
    public function run()
    {
        DB::table('factions')->insert([
            [
                'name' => 'Marauders', 
                'slug' => 'marauders', 
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Syndicate', 
                'slug' => 'syndicate', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Covenant',
                'slug' => 'covenant',
                 'created_at' => now(),
                 'updated_at' => now(),
            ],
        ]);
    }
}
