<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Models\Items\BaseWeapon;
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