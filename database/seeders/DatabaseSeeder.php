<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create Faction entries and override with default values
         \App\Models\User::factory()->create([
            'name' => 'Jess',
            'email' => 'epwnaz@gmail.com',
            'password' => Hash::make('password'),
            'remember_token' => null,
         ]);
         
//        \App\Models\User::factory(5)->create();

        // run other seeders
        $this->call([
            FactionSeeder::class,
            CompanySeeder::class,
            CharacterSeeder::class,
        ]);
    }
}
