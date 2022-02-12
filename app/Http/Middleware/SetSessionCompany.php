<?php

namespace App\Http\Middleware;

use App\Models\Companies\Company;
use App\Services\DiscordService;
use Closure;
use Illuminate\Http\Request;

class SetSessionCompany
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
        
        if(empty($request->user())){
            redirect(route('login'));
        }
        
        if(!empty($request->session()->get('team_id'))){
            return $next($request);
        }
        
        // find user's guilds that have registered on the app
        $guilds = $this->discordService->fetchUserGuilds($request->user());
        $guild_ids = collect($guilds)->pluck('id')->all();
     
        // match user guilds to registered companies
        $companies = Company::whereIn('discord_guild_id', $guild_ids);
        
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
