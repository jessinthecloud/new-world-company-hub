<?php

namespace Database\Factories;

use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'level' => $this->faker->numberBetween(1, 100),
//            'class' => $this->faker->randomAscii(),
            'company_id' => 1,
            'user_id' => 1,
//            'class_id' => 1,
//            'rank_id' => 1,
        ];
    }
}
