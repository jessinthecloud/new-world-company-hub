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
        return $next( $request );
    }
}