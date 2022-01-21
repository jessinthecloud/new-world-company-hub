<?php

namespace App\Services;

use App\Enums\ArmorType;
use App\Enums\WeightClass;
use App\Models\Items\Armor;
use App\Models\Items\BaseArmor;
use Illuminate\Support\Str;

class ArmorService extends ItemService implements ItemServiceContract
{
    public function __construct() {
        
    }
    
    /**
     * @return array
     */
    public function getAllBaseItems() : array
    {
        return BaseArmor::bankable()->orderBy('name')->orderBy('tier')->distinct()
            ->orderBy('name')/*->dd()->toSql();*/
            ->get()->mapWithKeys(function($base_armor){
        
            $wtype = $base_armor->type;
            $type = !empty($wtype) ? constant("App\Enums\ArmorType::$wtype")->value : null;
        
            return [$base_armor->slug => $base_armor->name . " (".(!empty($base_armor->weight_class) ? $base_armor->weight_class.' ' : '').$type.") Tier ".$base_armor->tier];
        })->all();
    }

    /**
     * @return string
     */
    public function baseItemsOptions() : string
    {
        $base_armor = $this->getAllBaseItems();

        $base_armor_options = '<option value=""></option>';
        foreach($base_armor as $value => $text) {
            $base_armor_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        return $base_armor_options;
    }

    /**
     * @return string
     */
    public function weightClassOptions() : string
    {
        $weight_class_options = '<option value="">None</option>';
        foreach(WeightClass::cases() as $type) {
            $weight_class_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $weight_class_options;
    }

    /**
     * @return string
     */
    public function itemTypeOptions() : string
    {
        $armor_type_options = '<option value=""></option>';
        foreach(collect(ArmorType::cases())->sortBy('value')->all() as $type) {
            $armor_type_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $armor_type_options;
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
            . ( !empty( $fields['weight_class'] ) ? ' ' . $fields['weight_class'] : '' )
        ;
        $slug = Str::slug( $slug );
        
        // see if slug exists in table 
        $slug_count = Armor::similarSlugs($slug.'%')->count();
        
        if($slug_count > 0){
            $slug .= '-x'.($slug_count+1);
        }
        
        return $slug;
    }
}