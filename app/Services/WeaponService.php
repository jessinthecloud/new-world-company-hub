<?php

namespace App\Services;

use App\Enums\WeaponType;
use App\Models\Items\BaseWeapon;

class WeaponService extends ItemService  implements ItemServiceContract
{
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
    public function baseItemsOptions() : string
    {
        $base_weapons = $this->getAllBaseItems();

        $base_weapon_options = '<option value=""></option>';
        foreach($base_weapons as $value => $text) {
            $base_weapon_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        return $base_weapon_options;
    }

    public function itemTypeOptions(  ) : string
    {
        $weapon_type_options = '<option value=""></option>';
        foreach(collect(WeaponType::cases())->sortBy('value')->all() as $type) {
            $weapon_type_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $weapon_type_options;
    }
}