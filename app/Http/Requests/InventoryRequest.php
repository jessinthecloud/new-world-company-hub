<?php

namespace App\Http\Requests;

use App\Enums\ArmorType;
use App\Enums\AttributeType;
use App\Enums\WeaponType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class InventoryRequest extends FormRequest
{
    public function rules() : array
    {
//    dd($this->request);
        return [
            'id'           => [],
            'base_id'           => [],
            'base_slug'           => ['string', 'nullable'],
            'slug'              => ['string', 'nullable'],
            'itemType'          => ['string', 'nullable'],
            'item'              => [
                /*Rule::requiredIf(function () {
                    return empty($this->name);
                }),*/
            ],
            // always input
            'gear_score'         => ['required', 'numeric'],
            // rarity always input
            'rarity'             => ['required_without:custom_rarity', /*new Enum(Rarity::class)*/],
            'custom_rarity'      => ['required_without:rarity', /*new Enum(Rarity::class)*/],
            
            // perks
            'perks'               => ['array', 'nullable'],
            'perks.*'             => ['exists:perks,slug', 'nullable'],
            'attrs'               => ['array', 'nullable'],
//            'attrs.*'             => [new Enum(AttributeType::class), 'nullable'],
            'attribute_amounts.*' => ['required_with:attributes', 'numeric', 'nullable'],
            
            // custom 
            'name'               => ['required_without:base_id', 'string', 'nullable'],
            'armor_type'         => [/*'required_if:is_armor,true',*/ /*new Enum(ArmorType::class),*/ 'nullable'],
            'weapon_type'        => [/*'required_if:is_weapon,true',*/ /*new Enum(WeaponType::class),*/ 'nullable'],
            'tier'               => [/*new Enum(Tier::class),*/ 'nullable'],
            'weight_class'       => ['nullable', /*new Enum(WeightClass::class)*/],
        ];
    }

    public function authorize() : bool
    {
        return true;
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'weapon_gear_score.numeric' => 'Gear score must be a number',
            'armor_gear_score.numeric' => 'Gear score must be a number',
            'weapon.required_if' => 'Weapon is required',
            'armor.required_if' => 'Armor is required',
        ];
    }
    
    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
//            'email' => 'email address',
        ];
    }
}