<?php

namespace App\Http\Middleware;

use App\Models\Characters\Character;
use App\Models\Companies\Company;
use App\Services\DiscordService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasCompany
{
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, DiscordService $discordService)
    {
        $response = $next($request);
dump( $request->user());
        
        if(!empty($request->user()) && !empty(session('team_id'))){
            return $response;
        }
        
        // find user's guilds that have registered on the app
        $guilds = $discordService->fetchUserGuilds($request->user());
        $guild_ids = collect($guilds)->pluck('id')->all();
        
        // match user guilds to registered companies
        $companies = Company::whereIn('discord_guild_id', $guild_ids);
        
        switch($companies->count()){
            case 0:
                // no match -> send away/send message to register app
                abort(403, 'Your discord server is not registered with this application.');
                break;
            case 1: 
                // single match -> set as selected team
                // see : https://spatie.be/docs/laravel-permission/v5/basic-usage/teams-permissions#working-with-teams-permissions
                return redirect(route('companies.login.login', [
                    'company' => $companies->first()->slug
                ]));
                break;
            default: 
                // multiple companies; send to a choose company page
                return redirect(route('companies.login.choose'));
                break;    
        }        
                
        return $response;
    }
}
