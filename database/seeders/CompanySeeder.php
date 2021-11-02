<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run()
    {
        DB::table('companies')->insert([
           [
               'name' => 'Gaiscioch',
               'tag' => 'GSCH',
               'faction_id' => 1,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           /* 
           [
               'name' => 'Gaiscioch',
               'tag' => 'GSCH',
               'faction_id' => 1,
           ],
           */
        ]);
    }
}
