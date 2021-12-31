<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Company;
use App\Models\Rank;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'level' => $this->faker->numberBetween(1, 100),
            'company_id' => Company::all()->random(),
            'user_id' => 1,
            // if these aren't here then other factories using
            // this factory throw an error 
            'character_class_id' => CharacterClass::all()->random()->id,
            'rank_id' => Rank::all()->random()->id,
        ];
    }
}
