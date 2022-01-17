<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // create User entries and override with default values
        
        $super = \App\Models\User::factory()
            ->create([
                'name' => 'Jess',
                'email' => 'super@test.com',
                'remember_token' => null,
            ]);
            
        $super->assignRole('super-admin');
        
        $gov = \App\Models\User::factory()
            ->create([
                'name' => 'Magz',
                'email' => 'magzreloadedtv@gmail.com',
                'remember_token' => null,
            ]);
            
        $gov->assignRole('governor');
        
    }
}
