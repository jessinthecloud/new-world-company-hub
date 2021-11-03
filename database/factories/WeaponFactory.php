<?php

namespace Database\Factories;

use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Database\Eloquent\Factories\Factory;

class WeaponFactory extends Factory
{
    protected $model = Weapon::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'weapon_type_id' => WeaponType::all()->random()->id,
        ];
    }
}
