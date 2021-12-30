<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Roster;
use Illuminate\Http\Request;

class RostersController extends Controller
{
    public function index()
    {
    }

    public function create()
    {
        //
    }

    public function store( Request $request )
    {
        //
    }

    public function show( Roster $roster=null )
    {
        ddd(Character::where('company_id', 1)->get()->all());
    }

    public function edit( Roster $roster )
    {
        //
    }

    public function update( Request $request, Roster $roster )
    {
        //
    }

    public function destroy( Roster $roster )
    {
        //
    }
}