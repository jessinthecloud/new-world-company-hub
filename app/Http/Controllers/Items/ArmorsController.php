<?php

namespace App\Http\Controllers\Items;

use App\Enums\AttributeType;
use App\Enums\Rarity;
use App\Http\Controllers\Controller;
use App\Models\Items\Armor;
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

    public function show( Request $request, Armor $armor )
    {
        $armor = $armor->load('perks', 'attributes');
        
        $rarity_color = Rarity::from($armor->rarity)->color();
        $attributes = $armor->attributes->map(function($attribute){
            return AttributeType::fromName($attribute->name)->value;
        })->all();
     
        return $request->query('popup') == 1
            ? view('armors.popup', [
                'armor' => $armor,
                'item_attributes' => $attributes,
                'rarity_color' => $rarity_color,
                'rarity' => strtolower($armor->rarity),
            ]) 
            : view('armors.show', [
                'armor' => $armor,
                'item_attributes' => $attributes,
                'rarity_color' => $rarity_color,
                'rarity' => strtolower($armor->rarity),
            ]);
    }

    public function edit( Armor $armor )
    {
        //
    }

    public function update( Request $request, Armor $armor )
    {
        //
    }

    public function destroy( Armor $armor )
    {
        //
    }
}