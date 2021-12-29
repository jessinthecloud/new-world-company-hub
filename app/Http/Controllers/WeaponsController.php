<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use Illuminate\Http\Request;

class WeaponsController extends Controller
{
    public function index()
    {
        $weapons = Weapon::orderBy('name')->get()->mapWithKeys(function($weapon){
            return [$weapon->id => $weapon->name];
        })->all();
        
        dump($weapons);
    }

    public function create()
    {
        //
    }

    public function store( Request $request )
    {
        //
    }

    public function show( Weapon $weapon )
    {
        //
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