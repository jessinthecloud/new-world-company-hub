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
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Syndicate', 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Covenant',
                 'created_at' => now(),
                 'updated_at' => now(),
            ],
        ]);
    }
}
