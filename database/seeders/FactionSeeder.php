<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FactionSeeder extends Seeder
{
    public function run()
    {
        DB::table('factions')->insert([
            ['name' => 'Marauders',],
            ['name' => 'Syndicate',],
            ['name' => 'Covenant',],
        ]);
    }
}
