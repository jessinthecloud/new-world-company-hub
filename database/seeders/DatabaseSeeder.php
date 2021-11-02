<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // create Faction entries and override with default values
         \App\Models\Faction::factory()->create(['name' => 'Marauders',]);
         \App\Models\Faction::factory()->create(['name' => 'Syndicate',]);
         \App\Models\Faction::factory()->create(['name' => 'Covenant',]);
    }
}
