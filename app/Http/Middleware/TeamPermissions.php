<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeamPermissions
{
    public function handle( Request $request, Closure $next )
    {
        if(!empty($request->user()) && !empty(session('team_id'))){
//dump($request->user(), $request->session());
//dump('team id is set: '.session('team_id'), 'before: '.getPermissionsTeamId());
            setPermissionsTeamId(session('team_id'));
//dump('after: '.getPermissionsTeamId());
        }
        
/*        dd( 
//    app(\Spatie\Permission\PermissionRegistrar::class),
        'spatie team id: '.getPermissionsTeamId(),
        'session team id: '.session('team_id'), 
//        $request->session(), 
        $request->user()->getAllPermissions()->pluck('name')->all(),
        $request->user()->getRoleNames()->all(),
        $request->user()->character()?->company->name 
     );*/
        
        return $next( $request );
    }
}