<?php

namespace Database\Factories;

use App\Models\Characters\Character;
use App\Models\Characters\Loadout;
use App\Models\Items\OldBaseWeapon;
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
            'main_hand_id' => OldBaseWeapon::all()->random()->id,
            'offhand_id' => OldBaseWeapon::all()->random()->id,
        ];
    }
}
