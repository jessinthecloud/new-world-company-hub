<?php

namespace App\Http\Middleware;

use App\Models\Characters\Character;
use App\Services\DiscordService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetSessionCharacter
{
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
        
        if(!empty($request->user()->character())){
            return $next($request);
        }
        
        // find user's characters tied to the current company (team_id)
        $characters = $request->user()->characters
            ->where('company.id', '=', $request->session()->get('team_id'));
        
        switch(true){
            case $characters->count() === 0:
                // no match -> create a character
                return redirect(route('characters.login.create'));
            case $characters->count() == 1: 
                // single match -> set as selected character
                return redirect(route('characters.login.login', [
                    'character' => $characters->first()->slug
                ]));
        }

        // multiple characters; send to choose a character page
        return redirect(route('characters.login.choose'));
    }
}
