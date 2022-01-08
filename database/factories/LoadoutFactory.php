<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\Loadout;
use App\Models\BaseWeapon;
use Illuminate\Database\Eloquent\Factories\Factory;

class LoadoutFactory extends Factory
{
    protected $model = Loadout::class;

    public function definition()
    {
        return [
            'name' => $this->faker->text(20),
            'weight' => $this->faker->numberBetween(1, 1000),
            'character_id' => Character::all()->random()->id,
            'main_hand_id' => BaseWeapon::all()->random()->id,
            'offhand_id' => BaseWeapon::all()->random()->id,
        ];
    }
}
