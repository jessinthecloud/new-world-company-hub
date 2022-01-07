<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use Illuminate\Http\Request;

class WeaponsController extends Controller
{
    public function index()
    {
        return view('weapon.index');
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