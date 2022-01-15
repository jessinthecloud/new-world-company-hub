<?php

namespace Database\Factories;

use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Company;
use App\Models\Rank;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

class CharacterFactory extends Factory
{
    protected $model = Character::class;
    
    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Character $character) {
            switch($character->rank->name){
                case "Governor":
                    $character->user->assignRole('governor');
                    break;
                case "Consul":
                    $character->user->assignRole('consul');
                    break;
                case "Officer":
                    $character->user->assignRole('officer');
                    break;
                case "Settler":
                    $character->user->assignRole('settler');
                    break;
            }
        });
    }

    public function definition() : array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'level' => $this->faker->numberBetween(1, 100),
            'character_class_id' => CharacterClass::inRandomOrder()->take(1)->id,
            'company_id' => Company::inRandomOrder()->take(1)->id,
            'user_id' => User::factory(),
            'rank_id' => 4, //Rank::all()->random()->id,
        ];
    }

    public function rank(int $rank_id, string $rank, int $company_id=1)
    {
        return $this->state(function (array $attributes) use ($rank_id, $rank, $company_id) {
            return [
                'rank_id' => $rank_id,
                'company_id' => $company_id,
                'user_id' => User::factory()->rank($rank),
            ];
        });
    }
}
