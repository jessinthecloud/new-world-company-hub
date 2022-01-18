<?php

namespace App\Http\Controllers\Items;

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
        
        return $request->query('popup') == 1
            ? view('armors.popup', ['armor' => $armor]) 
            : view('armors.show', ['armor' => $armor]);
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