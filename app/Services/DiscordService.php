<?php

namespace App\Services;

use App\Models\DiscordData;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Spatie\Permission\Models\Role;

class DiscordService
{
    public function upsertDiscordUser( $discordUser )
    {
        $user = User::where('discord_name',  $discordUser->nickname)->get();
//dd($discordUser);          
        if($user->isEmpty()){
            // account may exist prior to logging in with discord
            // and should be tied to discord data
            $user = User::updateOrCreate(
                [ 'email' => $discordUser->email, ],
                [
                    'name' => $discordUser->name,
                    'email' => $discordUser->email,
                    'discord_name' => $discordUser->nickname,
                ]
            );
            
            event(new Registered($user));
        }
        else{
            // user already exists in some way
            $user = $user->sole();
            $user->update([
                    'name' => $discordUser->name,
                    'email' => $discordUser->email,
                    'discord_name' => $discordUser->nickname,
                ]);
            $user->save();
        }
        
        // update or save discord data and tie to user
        DiscordData::updateOrCreate(
            [ 'email' => $discordUser->email, ],
            [
                'user_id' => $user->id,
                'discord_id' => $discordUser->id,
                'name' => $user->name,
                'nickname' => $discordUser->nickname,
                'email' => $user->email,
                'avatar' => $discordUser->avatar,
                'token' => $discordUser->token,
                'refresh_token' => $discordUser->refreshToken,
                'expires_in' => $discordUser->expiresIn,
            ]
        );
        
        return $user;
    }
    
    public function fetchUserGuilds( User $user)
    {
        return Cache::remember('user_'.$user->id.'_guilds', 900, 
            function() use($user) {
                return Http::withHeaders([
                   "Authorization" => "Bearer " . $user->discord->token
                ])
                ->acceptJson()
                ->get( "https://discord.com/api/users/@me/guilds" )
                ->json()
                ;
        });
    }

    public function fetchGuildMember( User $user, string $guild_id)
    {
        return Cache::remember('user_'.$user->id.'_guild_'.$guild_id.'_member', 900, 
            function() use($user, $guild_id) {
                return Http::withHeaders([
                   "Authorization" => "Bearer " . $user->discord->token
                ])
                ->acceptJson()
                ->get( "https://discord.com/api/users/@me/guilds/{$guild_id}/member" )
                ->json()
                ;
        });
    }

    public function syncUserRoles( User $user, int $company_id, array $discord_role_ids ) : array
    {
        $discord_roles = DB::table('discord_roles')
            ->select('role_id')
            ->where('company_id', '=', $company_id)
            ->whereIn('id', array_map('intval', $discord_role_ids))
            ->get();
        $role_ids = $discord_roles->pluck("role_id")->all();
//dump('company: '.$company_id, $discord_role_ids,'discord roles: ',$role_ids);

        $roles = Role::whereIn('id', $role_ids)->get()->pluck('name')->all();
//dump('app roles: ',$roles);
        if(!empty($roles)){
            $user->syncRoles($roles);
        }
        
        return $roles;
    }

    public function syncCharacterRanks( User $user, int $company_id, array $roles )
    {
        // TODO : find roles that have the same name as a rank
        // attach that rank to character
    }
}