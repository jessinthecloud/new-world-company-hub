<?php

namespace App\Services;

use App\Contracts\InventoryItemContract;
use App\Enums\WeaponType;
use App\Models\Items\OldBaseItem;
use App\Models\Items\OldBaseWeapon;
use App\Models\Items\Weapon;
use Illuminate\Support\Str;

class WeaponService extends ItemService implements ItemServiceContract
{
    protected string $itemClass = Weapon::class;
    protected string $baseItemClass = OldBaseWeapon::class;

    /**
     * @param bool $for_bank
     *
     * @return array
     */
    public function getAllBaseItems(bool $for_bank=true) : array
    {
        if($for_bank){
            $query = OldBaseWeapon::bankable();
        }
        else{
            $query = OldBaseWeapon::query();
        }
        return $query->orderBy('name')
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

    public function initItemAttributes( array $validated, OldBaseItem $base=null )
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