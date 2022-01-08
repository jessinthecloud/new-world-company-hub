<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuildBankSeeder extends Seeder
{
    public function run()
    {
        DB::table('guild_banks')->insert([
           [
               'company_id' => 1,
               'created_at' => now(),
               'updated_at' => now(),
           ],
       ]);
    }
}
