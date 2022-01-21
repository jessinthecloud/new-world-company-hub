<?php

namespace App\Services;

use App\Enums\WeaponType;
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
    public function baseItemsOptions() : string
    {
        $base_weapons = $this->getAllBaseItems();

        $base_weapon_options = '<option value=""></option>';
        foreach($base_weapons as $value => $text) {
            $base_weapon_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        return $base_weapon_options;
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

    /**
     * TODO: may need to make sure the slug found doesn't belong to the current item we are checking for. Can't just check for > 1 because current item's slug could be different now so an existing slug from another item would matter
     * 
     * @param array $fields
     *
     * @return string
     */
    public function createUniqueSlug(array $fields) : string
    {
        $slug = $fields['type'] . ' ' . $fields['name'] . ' ' 
            . ( !empty( $fields['rarity'] ) ? ' ' . $fields['rarity'] : '' ) 
            . ( !empty( $fields['tier'] ) ? ' t' . $fields['tier'] : '' )
        ;
        $slug = Str::slug( $slug );
        
        // see if slug exists in table 
        $slug_count = Weapon::similarSlugs($slug.'%')->count();
        
        if($slug_count > 0){
            $slug .= '-x'.($slug_count+1);
        }
        
        return $slug;
    }
}