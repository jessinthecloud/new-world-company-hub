<?php

namespace App\Http\Controllers\Items;

use App\Enums\WeaponType;
use App\Enums\AttributeType;
use App\Enums\Rarity;
use App\Http\Controllers\Controller;
use App\Models\Items\Weapon;
use Illuminate\Http\Request;

class WeaponsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store( Request $request )
    {
        //
    }

    public function show( Request $request, Weapon $weapon )
    {
        $weapon = $weapon->load('perks', 'attributes');
        
        $rarity_color = Rarity::from($weapon->rarity)->color();
        $attributes = $weapon->attributes->map(function($attribute){
            return AttributeType::fromName($attribute->name)->value;
        })->all();
        
        $weapon->type = WeaponType::fromName($weapon->type)->value;
        
        // empty perk slots
        $used_perk_slots = count($weapon->perks->all()) + count($weapon->attributes->all());
        if($used_perk_slots < $weapon->base->num_perk_slots){
            $empty_slots = $weapon->base->num_perk_slots - $used_perk_slots;
        }
        
        $view = $request->query('popup') == 1 ? 'weapons.popup' : 'weapons.show';
        
        return view($view, [
            'weapon' => $weapon,
            'item_attributes' => $attributes,
            'rarity_color' => $rarity_color,
            'empty_slots' => $empty_slots ?? null,
            'rarity' => strtolower($weapon->rarity),
        ]);
    }

    public function edit( Weapon $weapon )
    {
        //
    }

    public function update( Request $request, Weapon $weapon )
    {
        //
    }

    public function destroy( Weapon $weapon )
    {
        //
    }
}