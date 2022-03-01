<?php

namespace App\Http\Controllers\Items;

use App\Enums\WeaponType;
use App\Enums\AttributeType;
use App\Enums\Rarity;
use App\Http\Controllers\Controller;
use App\Models\Items\OldWeapon;
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

    public function show( Request $request, OldWeapon $weapon )
    {
        $weapon = $weapon->load('perks', 'itemAttributes');
        
        $rarity_color = Rarity::from($weapon->rarity)->color();
        $attributes = $weapon->itemAttributes->map(function($attribute){
            return AttributeType::fromName($attribute->name)->value;
        })->all();
        
        $weapon->type = null !== WeaponType::from($weapon->type) 
            ? WeaponType::from($weapon->type)->value 
            : $weapon->type;
        
        // empty perk slots
        $used_perk_slots = count($weapon->perks->all()) + count($weapon->itemAttributes->all());
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

    public function edit( OldWeapon $weapon )
    {
        //
    }

    public function update( Request $request, OldWeapon $weapon )
    {
        //
    }

    public function destroy( OldWeapon $weapon )
    {
        //
    }
}