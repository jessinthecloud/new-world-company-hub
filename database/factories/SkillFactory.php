<?php

namespace Database\Factories;

use App\Models\Characters\Skill;
use App\Models\Characters\SkillType;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'description' => $this->faker->realText(),
            'order' => $this->faker->numberBetween(1, 50),
            'skill_type_id' => SkillType::all()->random(),
        ];
    }
}
