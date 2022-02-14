<?php

namespace App\Services;

use App\Models\Companies\Rank;
use App\Models\DiscordData;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DiscordService
{
    public function upsertDiscordUser( $discordUser )
    {
        $user = User::where('discord_name',  $discordUser->nickname)->get();
      
        if($user->isEmpty()){
            // account may exist prior to logging in with discord
            // and should be tied to discord data
            $user = User::updateOrCreate(
                [ 'email' => $discordUser->email, ],
                [
                    'name' => $discordUser->name,
                    'slug' => Str::slug($discordUser->name),
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
                'slug' => Str::slug($discordUser->name),
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
        return Cache::remember('user_'.$user->id.'_guilds', 90, 
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
        return Cache::remember('user_'.$user->id.'_guild_'.$guild_id.'_member', 90, 
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
        
        $roles = Role::whereIn('id', $role_ids)->get()->pluck('name')->all();

        if(!empty($roles)){
            $user->syncRoles($roles);
            // get rank from user roles
            $rank = Rank::whereIn('name', $roles)->orderBy('order')->first();
        }
        
        // if no ranks, but have member role, add settler rank
        if(empty($rank) && in_array('breakpoint-member', $roles)){
            $rank = Rank::where('name', 'Settler')->first();
            $character = $user->characters->where('company_id', $company_id)->first();
            if(isset($character)){
                $character->rank_id = $rank->id;
                $character->save();
            }
        }
        
        if($user->isSuperAdmin()){
            // make sure super admin stays if it was removed via the sync
            $user->assignRole('super-admin');
        }
        
        return $roles;
    }
}