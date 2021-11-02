<?php

namespace Database\Factories;

use App\Models\Faction;
use Illuminate\Database\Eloquent\Factories\Factory;

class FactionFactory extends Factory
{
    protected $model = Faction::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),            
        ];
    }
}
