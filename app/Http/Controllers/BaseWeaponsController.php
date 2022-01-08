<?php

namespace App\Http\Controllers;

use App\Models\BaseWeapon;
use Illuminate\Http\Request;

class BaseWeaponsController extends Controller
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

    public function show( BaseWeapon $weapon )
    {        
        //
    }

    public function edit( BaseWeapon $weapon )
    {
        //
    }

    public function update( Request $request, BaseWeapon $weapon )
    {
        //
    }

    public function destroy( BaseWeapon $weapon )
    {
        //
    }
}