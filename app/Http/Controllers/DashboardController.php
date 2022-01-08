<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index( Request $request )
    {
//        dump( $request->user(), $request->user()->character() );

        // determine what user is allowed to see on the dashboard
        $user = $request->user();

        return view( 'dashboard.index', [
            'form_action' => route( 'dashboard' ),
            'character'   => $user->character(),
            'faction'     => $user->faction(),
            'company'     => $user->company(),
            'rank'        => $user->rank(),
            'characters'  => $user->characters,
            'loadout'     => $user->character()?->loadout,
            // import
            // rosters
            // events
        ] );
    }
}