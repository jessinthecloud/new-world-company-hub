<?php

namespace App\Http\Controllers\Items;

use App\Enums\ArmorType;
use App\Enums\AttributeType;
use App\Enums\Rarity;
use App\Http\Controllers\Controller;
use App\Models\Items\OldArmor;
use Illuminate\Http\Request;

class ArmorsController extends Controller
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

    public function show( Request $request, OldArmor $armor )
    {
        $armor = $armor->load('perks', 'itemAttributes');
        
        $rarity_color = Rarity::from($armor->rarity)->color();
        $attributes = $armor->itemAttributes->map(function($attribute){
            return AttributeType::fromName($attribute->name)->value;
        })->all();
        
        $armor->type = null !== ArmorType::fromName($armor->type) 
            ? ArmorType::fromName($armor->type)->value 
            : $armor->type;
        
        // empty perk slots
        $used_perk_slots = count($armor->perks->all()) + count($armor->itemAttributes->all());
        if($used_perk_slots < $armor->base->num_perk_slots){
            $empty_slots = $armor->base->num_perk_slots - $used_perk_slots;
        }
        
        $view = $request->query('popup') == 1 ? 'armors.popup' : 'armors.show';
        
        return view($view, [
            'armor' => $armor,
            'item_attributes' => $attributes,
            'rarity_color' => $rarity_color,
            'empty_slots' => $empty_slots ?? null,
            'rarity' => strtolower($armor->rarity),
        ]);
    }

    public function edit( OldArmor $armor )
    {
        //
    }

    public function update( Request $request, OldArmor $armor )
    {
        //
    }

    public function destroy( OldArmor $armor )
    {
        //
    }
}