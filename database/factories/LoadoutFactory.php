<?php

namespace Database\Factories;

use App\Models\Loadout;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoadoutFactory extends Factory
{
    protected $model = Loadout::class;

    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'weight' => $this->faker->numberBetween(1, 1000),
        ];
    }
}
