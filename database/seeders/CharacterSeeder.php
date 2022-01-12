<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Rank;
use Illuminate\Database\Eloquent\Factories\Sequence;

class CharacterSeeder extends Seeder
{
    public function run()
    {
        Character::factory()
            ->count(10)
            ->hasAttached(
                Skill::all()->random(Skill::count()),
                ['level' => abs(rand(0,100))],
            )
            ->create();
            
        Character::factory()->rank(1, 'governor')->create();
        Character::factory()->rank(2, 'consul')->create();
        Character::factory()->rank(3, 'officer')->create();
        Character::factory()->rank(4, 'settler')->create();
    }
}
