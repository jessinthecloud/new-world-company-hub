<?php

namespace Database\Factories\Items;

use App\Enums\ArmorType;
use App\Enums\Rarity;
use App\Enums\Tier;
use App\Enums\WeightClass;
use App\Models\Items\Armor;
use App\Models\Items\BaseArmor;
use Illuminate\Database\Eloquent\Factories\Factory;

use function collect;

class ArmorFactory extends Factory
{
    protected $model = Armor::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->unique()->slug(),
            'type' => collect(ArmorType::cases())->random()->value, 
            'description' => $this->faker->paragraph(3), 
            'tier' => collect(Tier::cases())->random()->value, 
            'rarity' => collect(Rarity::cases())->random()->value, 
            'gear_score' => $this->faker->numberBetween(100, 600),
            'required_level' => $this->faker->numberBetween(1, 100),
        ];
    }

    public function fromBase($baseArmor=null)
    {        
        // get base armor
        // make sure isn't already used (slug must be unique)
        $baseArmor ??= BaseArmor::whereNotIn('slug', 
            Armor::all()->pluck('slug')->all() 
        )->has('perks')->inRandomOrder()->take(1)->get();
// dump($baseArmor->id);
// dump($baseArmor->perks);
        return $this->state(function (array $attributes) use ($baseArmor) {
            return [
                'base_id' => $baseArmor->id,
                'name' => $baseArmor->name,
                'slug' => $baseArmor->slug,
                'type' => ArmorType::fromName($baseArmor->type)->value,
                'description' => $baseArmor->description ?? null,
                'tier' => Tier::fromName("T".$baseArmor->tier)->value ?? null,
                'rarity' => Rarity::fromName("R".$baseArmor->rarity)->value ?? null,
                'weight_class' => WeightClass::fromName($baseArmor->weight_class ?? '')->value ?? null,
                'gear_score' => $baseWeapon->gear_score ?? $this->faker->numberBetween(100, 600),
                'required_level' => $baseWeapon->required_level ?? $this->faker->numberBetween(1, 100),
            ];
        })
        ->hasAttached($baseArmor->perks)
        ;
    }
}
