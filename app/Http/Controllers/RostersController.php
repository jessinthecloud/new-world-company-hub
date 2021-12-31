<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Roster;
use Illuminate\Http\Request;

class RostersController extends Controller
{
    public function index()
    {
        //
    }
    
    public function choose()
    {
        $rosters = Roster::with('roster')->orderBy('name')->get()->mapWithKeys(function($roster){
            return [$roster->name.' ('.$roster->faction->name.')' => $roster->id];
        })->all();
        $form_action = route('rosters.find');

        return view(
            'dashboard.roster.choose',
            compact('rosters', 'form_action')
        );
    }

    public function find(Request $request)
    {
//    ddd($request);
        return redirect(route('rosters.'.$request->action, ['roster'=>$request->roster]));
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