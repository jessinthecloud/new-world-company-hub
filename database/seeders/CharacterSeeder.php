<?php

namespace Database\Seeders;

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
            // don't need state because seeder has these set
            ->state(new Sequence(
                    fn ($sequence) => [
                        'character_class_id' => CharacterClass::all()->random(),
                        'rank_id' => Rank::all()->random()
                    ],
                )
            )
            ->hasAttached(
                Skill::all()->random(3),
                ['level' => abs(rand(1,100))],
            )
            ->create();
    }
}
