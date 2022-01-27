<?php

namespace App\Http\Middleware;

use App\Models\Characters\Character;
use Closure;
use Illuminate\Http\Request;

class EnsureUserHasCompany
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
        $response = $next($request);
dump( $request->user());
        
        if(!empty($request->user()->character())){
            return $response;
        }

        $characters = Character::forUser($request->user()->id);
dump($characters->get());
        dd($characters->count(), $request->session()->get('discord_guild_id'));

        switch ($characters->count()){
            case 0:
                // create character
                $request->session()->flash(
                    'discord_guild_id', 
                    $request->session()->get('discord_guild_id')
                );
                
                break;
            case 1:
                // only one, then choose it automatically 
                return redirect(route('characters.login', [
                    'character' => $characters->first()->slug
                ]));
            default:
                // choose character
                return redirect(route('characters.login.choose'));
                break;
        }
        
                
        return $response;
    }
}
