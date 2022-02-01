<?php

namespace App\Http\Controllers;

use App\CompanyInventory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index( Request $request )
    {
    /*dump( 
//    app(\Spatie\Permission\PermissionRegistrar::class),
        'spatie team id: '.getPermissionsTeamId(),
        'session team id: '.session('team_id'), 
//        $request->session(), 
        $request->user()->getAllPermissions()->pluck('name')->all(),
        $request->user()->getRoleNames()->all(),
//        $request->user()->character(),
//        $request->user()->characters,
     );*/

        // determine what user is allowed to see on the dashboard
        $user = $request->user();

        return view( 'dashboard.index', [
            'form_action' => route( 'dashboard' ),
            'character'   => $user->character(),
            'faction'     => $user->faction(),
            'company'     => $user->company(),
            'companyInventory' => CompanyInventory::find($user->company()->id),
            'rank'        => $user->rank(),
            'characters'  => $user->characters,
            'loadout'     => $user->character()?->loadout,
            // import
            // rosters
            // events
        ] );
    }
}