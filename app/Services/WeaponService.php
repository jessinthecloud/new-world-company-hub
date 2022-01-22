<?php

namespace App\Services;

use App\Contracts\InventoryItemContract;
use App\Enums\WeaponType;
use App\Models\Items\BaseItem;
use App\Models\Items\BaseWeapon;
use App\Models\Items\Weapon;
use Illuminate\Support\Str;

class WeaponService extends ItemService implements ItemServiceContract
{
    protected string $itemClass = Weapon::class;
    protected string $baseItemClass = BaseWeapon::class;

    /**
     * @return array
     */
    public function getAllBaseItems() : array
    {
        return BaseWeapon::bankable()->orderBy('name')->orderBy('tier')->distinct()->get()->mapWithKeys(function($base_weapon){
        $wtype = $base_weapon->type;
        $type = !empty($wtype) ? constant("App\Enums\WeaponType::$wtype")->value : null;
        
            return [$base_weapon->slug => $base_weapon->name . " ($type) Tier ".$base_weapon->tier];
        })->all();   
    }
    
    /**
     * @return string
     */
    public function itemTypeOptions(  ) : string
    {
        $weapon_type_options = '<option value=""></option>';
        foreach(collect(WeaponType::cases())->sortBy('value')->all() as $type) {
            $weapon_type_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $weapon_type_options;
    }
        
    public function createItem(array $validated, BaseItem $base=null)
    {
        // get base weapon
        $base ??= $this->baseItem($validated['weapon']);

        $name = $validated['name'] ?? $base->name;
        $description = $validated['description'] ?? $base?->description ?? null;
        $gear_score = $validated['gear_score'] ?? $validated['weapon_gear_score'] 
            ?? $base->gear_score ?? null;
        
        $rarity_input = $validated['rarity'];
        $rarity = !empty($rarity_input) 
            ? constant("App\Enums\Rarity::$rarity_input")?->value 
            : $base->rarity ?? null;
            
        $tier_input = $validated['tier'];
        $tier = !empty($tier_input) 
            ? constant("App\Enums\Tier::$tier_input")?->value 
            : $base?->tier ?? null;
            
        $type_input = $validated['weapon_type'];
        $type = !empty($type_input) 
            ? constant("App\Enums\WeaponType::$type_input")?->value 
            : $base->type ?? null;
            
        $values = [
            'name' => $name,
            'type' => $type,
            'description' => $description,
            'tier' => $tier,
            'rarity' => $rarity,
            'gear_score' => $gear_score,
       ];
            
        // determine unique slug
        $values ['slug']= $this->createUniqueSlug($values);
        
dump('created slug: '.$values ['slug']);        
       
       return Weapon::create($values);
    }
}