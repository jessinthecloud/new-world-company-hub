<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Models\Events\Roster;
use Illuminate\Http\Request;

use function redirect;
use function route;
use function view;

class RostersController extends Controller
{
    public function index()
    {
        //
    }
    
    public function choose()
    {
        $rosters = \App\Models\Events\Roster::with('roster')->orderBy('name')->get()->mapWithKeys(function($roster){
            return [$roster->id => $roster->name.' ('.$roster->faction->name.')'];
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

    public function show( \App\Models\Events\Roster $roster=null )
    {
        //
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