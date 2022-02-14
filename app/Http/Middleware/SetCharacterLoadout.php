<?php

namespace App\Http\Middleware;

use App\Models\Characters\Character;
use App\Services\DiscordService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetCharacterLoadout
{
    public function __construct(protected DiscordService $discordService) { }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
//dump( $request->user(), $request->session()->get('team_id'));
        
        if(empty($request->user())){
            redirect(route('login'));
        }
        
        // make sure char info is up-to-date
        if($request->user()->character()->isDirty()){
            $request->user()->character()->refresh();
        }

        if(!empty($request->user()->character()->loadout)){
            return $next($request);
        }
        
        // create a loadout
        return redirect(route('loadouts.create', ['login'=>1]));
    }
}
