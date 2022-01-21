<?php

namespace App\Services;

use App\Enums\AttributeType;
use App\Enums\Rarity;
use App\Enums\Tier;
use App\Models\Items\Perk;

abstract class ItemService implements ItemServiceContract
{
    public function perkOptions(  ) : string
    {
        $perks = Perk::orderBy('name')->distinct()->get()->mapWithKeys(function($perk){
            return [$perk->slug => $perk->name];
        })->all();

        $perk_options = '<option value=""></option>';
        foreach($perks as $value => $text) {
            $perk_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        return $perk_options;
    }

    public function rarityOptions(  ) : string
    {
        $rarity_options = '<option value=""></option>';
        foreach(Rarity::cases() as $type) {
            $rarity_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $rarity_options;
    }

    public function tierOptions(  )
    {
        $tier_options = '<option value=""></option>';
        foreach(Tier::cases() as $type) {
            $tier_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $tier_options;
    }

    public function attributeOptions(  )
    {
        $attribute_options = '<option value=""></option>';
        foreach(collect(AttributeType::cases())->sortBy('value')->all() as $type) {
            $attribute_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $attribute_options;
    }
}