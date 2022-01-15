<?php

namespace Database\Seeders;

use App\Models\Characters\Character;
use App\Models\Characters\Skill;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    public function run()
    {
        Character::factory()
            ->count(10)
            ->hasAttached(
                Skill::inRandomOrder()->take(1)->get(),
                ['level' => abs(rand(0,100))],
            )
            ->create();
            
        Character::factory()->rank(1, 'governor')->create();
        Character::factory()->rank(2, 'consul')->create();
        Character::factory()->rank(3, 'officer')->create();
        Character::factory()->rank(4, 'settler')->create();
    }
}
