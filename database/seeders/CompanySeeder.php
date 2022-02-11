<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run()
    {
        DB::table('companies')->upsert([
           [
               'name' => 'Breakpoint',
               'slug' => 'breakpoint',
               'faction_id' => 1,
               'discord_guild_id' => '895006799319666718',
               'created_at' => now(),
               'updated_at' => now(),
           ],
        ], ['slug']);
    }
}
