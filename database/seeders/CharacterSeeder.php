<?php

namespace Database\Seeders;

use App\Models\Character;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    public function run()
    {
        Character::factory()
            ->count(10)/*
            ->state(new Sequence(
                fn ($sequence) => ['role' => UserRoles::all()->random()],
            ))*/
            ->create();
    }
}
