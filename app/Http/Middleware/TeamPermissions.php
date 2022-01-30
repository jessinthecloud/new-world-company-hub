<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeamPermissions
{
    public function handle( Request $request, Closure $next )
    {
        if(!empty($request->user()) && !empty(session('team_id'))){
            setPermissionsTeamId(session('team_id'));
        }
        
        return $next( $request );
    }
}