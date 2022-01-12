<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        
    }
}
