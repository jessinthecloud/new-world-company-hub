<?php

namespace App\Http\Requests;

use App\Models\Characters\Loadout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class LoadoutUpsertRequest extends FormRequest
{
    public function authorize() : bool
    {
        return $this->route('loadout') != null 
            ? $this->user()->can('update', $this->route('loadout')) 
            : $this->user()->can('create', Loadout::class);
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
            'gear_score.character' => ['required', 'numeric'],
            'weight'     => ['nullable', 'numeric', 'max:10000'],
//            'character'  => ['required', 'integer', 'exists:characters,id'],
            'equipment_slot_names' => ['array'],
        ];
        
        // TODO: refactor required vs optional checks
        foreach ( $required_equipment as $item ) {
            // weapons or armors table
            $item_table_to_check = strtolower(Str::plural($this->get('itemType')[$item]));
      
            // fields for edit
            $rules[ 'id.'.$item] = ['nullable', 'integer', 'exists:'.$item_table_to_check.',id'];
            $rules[ 'slug.'.$item] = ['string', 'nullable'];
            $rules[ 'itemType.'.$item] = ['string', 'nullable'];
            // auto filled fields
            $rules[ 'base_id.'.$item] = [];
            $rules[ 'base_slug.'.$item] = ['string', 'nullable'];
            // entered fields
            $rules[$item] = ['required',];
            $rules[ 'gear_score.'.$item] = ['required', 'numeric'];
            $rules[ 'rarity.'.$item] = ['required', /*new Enum(Rarity::class)*/];
            $rules['tier.'.$item] = ['nullable', /*new Enum(Tier::class),*/ ];

            // perks
            $rules['perks.'.$item] = ['array', 'nullable'];
            $rules['perks.'.$item.'.*'] = ['exists:perks,slug', 'nullable'];
            $rules['attrs.'.$item] = ['array', 'nullable'];
            $rules['attribute_amounts.'.$item.'.*'] = ['required_with:attributes', 'numeric', 'nullable'];
            
//            if ( $item == 'main' || $item == 'offhand' || $item == 'shield' ) {
                /*// is weapon
                $rules['weapon_type'] = [
                    //'required_if:is_weapon,true', 
                    //new Enum(WeaponType::class),
                    'required',
                ];*/
//            } else {
                /*// is armor
                $rules['armor_type']= [
                    //'required_if:is_armor,true', 
                    //new Enum(ArmorType::class),
                    'required',
                ];*/
//                $rules['weight_class'] = ['required', /*new Enum(WeightClass::class)*/];
//            }
        }
        
        foreach ( $other_equipment as $item ) {
            // fields for edit
            // weapons or armors table
            $item_table_to_check = strtolower(Str::plural($this->get('itemType')[$item]));
      
            // fields for edit
            $rules[ 'id.'.$item] = ['nullable', 'integer', 'exists:'.$item_table_to_check.',id'];
            $rules[ 'slug.'.$item] = ['string', 'nullable'];
            $rules[ 'itemType.'.$item] = ['string', 'nullable'];
            // automatically filled fields
            $rules[ 'base_id.'.$item] = [];
            $rules[ 'base_slug.'.$item] = ['string', 'nullable'];
            // entered fields
            $rules[ $item ] = ['nullable',];
            $rules[ 'gear_score.'.$item] = ['nullable', 'numeric'];
            $rules[ 'rarity.'.$item] = ['nullable', /*new Enum(Rarity::class)*/];
            $rules['tier.'.$item] = ['nullable', /*new Enum(Tier::class),*/ ];

            // perks
            $rules['perks.'.$item] = ['array', 'nullable'];
            $rules['perks.'.$item.'.*'] = ['exists:perks,slug', 'nullable'];
            $rules['attrs.'.$item] = ['array', 'nullable'];
            $rules['attribute_amounts.'.$item.'.*'] = ['required_with:attributes', 'numeric', 'nullable'];
            
//            if ( $item == 'main' || $item == 'offhand' || $item == 'shield' ) {
                /*// is weapon
                $rules['weapon_type'] = [
                    //'required_if:is_weapon,true', 
                    //new Enum(WeaponType::class),
                    'nullable',
                ];*/
//            } else {
                /*// is armor
                $rules['armor_type']= [
                    //'required_if:is_armor,true', 
                    //new Enum(ArmorType::class),
                    'nullable',
                ];*/
//                $rules['weight_class'] = ['required', /*new Enum(WeightClass::class)*/];
//            }
        }

        return $rules;
    }
}