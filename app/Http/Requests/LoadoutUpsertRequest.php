<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadoutUpsertRequest extends FormRequest
{
    public function authorize() : bool
    {
        return $this->user()->can('update', $this->user()->loadout());
    }
    
    public function rules() : array
    {
        $required_equipment = [
            'main',
            'offhand',
            'head',
            'chest',
            'legs',
            'feet',
            'hands',
            'neck',
            'ring',
            'earring',
        ];
        
        $other_equipment = [
            'shield',
        ];

        $rules = [
//            'name'       => ['string', 'max:255', 'nullable'],
            'gear_score' => ['required', 'numeric'],
            'weight'     => ['nullable', 'numeric', 'max:10000'],
//            'character'  => ['required', 'integer', 'exists:characters,id'],
            'equipment_slot_name' => [],
        ];
        
        // TODO: refactor required vs optional checks
        foreach ( $required_equipment as $item ) {
            // fields for edit
            $rules[ $item . '_id' ] = ['nullable', 'integer', 'exists:inventory_items,id'];
            $rules[ $item . '_slug' ] = ['string', 'nullable'];
            // auto filled fields
            $rules[ $item . '_base_id' ] = [];
            $rules[ $item . '_base_slug' ] = ['string', 'nullable'];
            // entered fields
            $rules[ $item . '_item_name' ] = ['required',];
            $rules[ $item . '_gear_score' ] = ['required', 'numeric'];
            $rules[ $item . '_rarity' ] = ['required', /*new Enum(Rarity::class)*/];
            $rules[$item . '_tier'] = ['nullable', /*new Enum(Tier::class),*/ ];

            // perks
            $rules[$item . '_perks'] = ['array', 'nullable'];
            $rules[$item . '_perks.*'] = ['exists:perks,slug', 'nullable'];
            $rules[$item . '_attrs'] = ['array', 'nullable'];
            $rules[$item . '_attribute_amounts.*'] = ['required_with:attributes', 'numeric', 'nullable'];
            
//            if ( $item == 'main' || $item == 'offhand' || $item == 'shield' ) {
                /*// is weapon
                $rules[$item . '_weapon_type'] = [
                    //'required_if:is_weapon,true', 
                    //new Enum(WeaponType::class),
                    'required',
                ];*/
//            } else {
                /*// is armor
                $rules[$item . '_armor_type']= [
                    //'required_if:is_armor,true', 
                    //new Enum(ArmorType::class),
                    'required',
                ];*/
//                $rules[$item . '_weight_class'] = ['required', /*new Enum(WeightClass::class)*/];
//            }
        }
        
        foreach ( $other_equipment as $item ) {
            // fields for edit
            $rules[ $item . '_id' ] = ['nullable', 'integer', 'exists:inventory_items,id'];
            $rules[ $item . '_slug' ] = ['string', 'nullable'];
            // auto filled fields
            $rules[ $item . '_base_id' ] = [];
            $rules[ $item . '_base_slug' ] = ['string', 'nullable'];
            // entered fields
            $rules[ $item ] = ['nullable',];
            $rules[ $item . '_gear_score' ] = ['nullable', 'numeric'];
            $rules[ $item . '_rarity' ] = ['nullable', /*new Enum(Rarity::class)*/];
            $rules[$item . '_tier'] = ['nullable', /*new Enum(Tier::class),*/ ];

            // perks
            $rules[$item . '_perks'] = ['array', 'nullable'];
            $rules[$item . '_perks.*'] = ['exists:perks,slug', 'nullable'];
            $rules[$item . '_attrs'] = ['array', 'nullable'];
            $rules[$item . '_attribute_amounts.*'] = ['required_with:attributes', 'numeric', 'nullable'];
            
//            if ( $item == 'main' || $item == 'offhand' || $item == 'shield' ) {
                /*// is weapon
                $rules[$item . '_weapon_type'] = [
                    //'required_if:is_weapon,true', 
                    //new Enum(WeaponType::class),
                    'nullable',
                ];*/
//            } else {
                /*// is armor
                $rules[$item . '_armor_type']= [
                    //'required_if:is_armor,true', 
                    //new Enum(ArmorType::class),
                    'nullable',
                ];*/
//                $rules[$item . '_weight_class'] = ['required', /*new Enum(WeightClass::class)*/];
//            }
        }

        return $rules;
    }
}