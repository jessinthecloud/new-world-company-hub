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
        
        if(!empty($request->session()->get('team_id'))){
//dd('team id is set: '.$request->session()->get('team_id'));        
            return $next($request);
        }
        
        // find user's guilds that have registered on the app
        $guilds = $this->discordService->fetchUserGuilds($request->user());
        $guild_ids = collect($guilds)->pluck('id')->all();
//dump($request->user(),'guilds', collect($guilds)->pluck('name'), $guild_ids);        
        // match user guilds to registered companies
        $companies = Company::whereIn('discord_guild_id', $guild_ids);
//dd('companies', $companies->pluck('name'));        
        switch(true){
            case $companies->count() === 0:
                // no match -> send away/send message to register app
                abort(403, 'Your discord server is not registered with this application.');
            case $companies->count() == 1: 
                // single match -> set as selected team
                // see : https://spatie.be/docs/laravel-permission/v5/basic-usage/teams-permissions#working-with-teams-permissions
                return redirect(route('companies.login.login', [
                    'company' => $companies->first()->slug
                ]));
        }

        // multiple companies; send to choose a company page
        return redirect(route('companies.login.choose'));
    }
}
