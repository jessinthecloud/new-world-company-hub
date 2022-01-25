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
        return BaseWeapon::bankable()
            ->orderBy('name')
            ->orderBy('tier')
            ->distinct()
            ->get()->mapWithKeys(function($base_weapon){
        $wtype = $base_weapon->type;
        $type = !empty($wtype) 
            ? constant("App\Enums\WeaponType::$wtype")->value 
            : null;
        
            return [$base_weapon->slug => $base_weapon->name . " ($type) Tier ".$base_weapon->tier];
        })->all();   
    }

    /**
     * @param string $itemType
     *
     * @return string
     */
    public function itemTypeOptions( string $itemType='' ) : string
    {
        $weapon_type_options = '<option value=""></option>';
        foreach(collect(WeaponType::cases())->sortBy('value')->all() as $type) {
            $weapon_type_options .= '<option value="'.$type->name.'"';
                if(strtolower($type->value) == strtolower($itemType)){
                    $weapon_type_options .= ' SELECTED ';
                }
            $weapon_type_options .= '>'.$type->value.'</option>';
        }
        
        return $weapon_type_options;
    }

    public function initItemAttributes( array $validated, BaseItem $base=null )
    {
        $values = [];
        
        $type_input = $validated['weapon_type'];
//        $typeEnum = \App\Enums\WeaponType::class;
        $type = !empty($type_input) 
            ? constant("App\Enums\WeaponType::$type_input")?->value 
            : constant("App\Enums\WeaponType::{$base?->type}")?->value 
            ?? $base?->type ?? null;

        $values ['type']= $type;

        return array_merge( 
            $values, 
            $this->initGenericItemAttributes( $validated, $values, $base )
        );
    }
}