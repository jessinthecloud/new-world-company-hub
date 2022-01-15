<?php

namespace Database\Factories\Items;

use App\Enums\Rarity;
use App\Enums\Tier;
use App\Enums\WeaponType;
use App\Models\Items\BaseWeapon;
use App\Models\Items\Weapon;
use Illuminate\Database\Eloquent\Factories\Factory;

use function collect;

class WeaponFactory extends Factory
{
    protected $model = Weapon::class;

    public function definition() : array
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->unique()->slug(),
            'type' => collect(WeaponType::cases())->random()->value, 
            'description' => $this->faker->paragraph(3), 
            'tier' => collect(Tier::cases())->random()->value, 
            'rarity' => collect(Rarity::cases())->random()->value, 
            'gear_score' => $this->faker->numberBetween(100, 600),
            'required_level' => $this->faker->numberBetween(1, 100),
        ];
    }

    public function fromBase($baseWeapon=null)
    {        
        // get base weapon
        // make sure isn't already used (slug must be unique)
        $baseWeapon ??= BaseWeapon::whereNotIn('slug', 
            Weapon::all()->pluck('slug')->all() 
        )->has('perks')->inRandomOrder()->take(1)->get();
 
        return $this->state(function (array $attributes) use ($baseWeapon) {
            return [
                'base_id' => $baseWeapon->id,
                'name' => $baseWeapon->name,
                'slug' => $baseWeapon->slug,
                'type' => WeaponType::fromName($baseWeapon->type)->value,
                'description' => $baseWeapon->description ?? null,
                'tier' => Tier::fromName("T".$baseWeapon->tier)->value ?? null,
                'rarity' => Rarity::fromName("R".$baseWeapon->rarity)->value ?? null,
                'gear_score' => $baseWeapon->gear_score ?? $this->faker->numberBetween(100, 600),
                'required_level' => $baseWeapon->required_level ?? $this->faker->numberBetween(1, 100),
            ];
        })
        ->hasAttached($baseWeapon->perks)
        ;
    }
}
