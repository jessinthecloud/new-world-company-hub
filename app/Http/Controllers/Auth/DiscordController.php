<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class DiscordController extends Controller
{
    /**
     * Redirect the user to the Discord authentication page.
     *
     * When someone navigates to this URL, they will be prompted
     * to authorize your application for the requested scopes.
     *
     * On acceptance, they will be redirected to your redirect_uri,
     * which will contain an additional query string parameter: code.
     * state will also be returned if previously sent, and should
     * be validated at this point.
     *
     * @see https://discord.com/developers/docs/topics/oauth2#authorization-code-grant
     * @see https://socialiteproviders.com/usage/
     * @see https://github.com/SocialiteProviders/Discord
     * @see https://github.com/martinbean/socialite-discord-provider
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('discord')
            // add additional scopes (stuff we can access)
            // all scopes: https://discord.com/developers/docs/topics/oauth2#shared-resources-oauth2-scopes
            ->scopes(['guilds'])
            ->redirect();
    }

    /**
     * Obtain the user information from Discord.
     * 
     * The user object returned by the user method provides a
     * variety of properties and methods you may use to store
     * information about the user in your own database
     *
     * @see https://discord.com/developers/docs/topics/oauth2#authorization-code-grant-access-token-response
     * @see https://laravel.com/docs/8.x/socialite#retrieving-user-details
     * 
     * @return \Illuminate\Http\Response
     */
    public function callback()
    {
        /* @throws ClientException */
        /* @throws InvalidStateException */ 
        $user = Socialite::driver('discord')->user();

        /**
         * User Info returned:
         *
         * id
         * nickname
         * name
         * email
         * avatar
         * 
         * token
         * refreshToken
         * expiresIn
         */
        dump($user);
        
        $user = User::firstOrCreate(
            ['email' => $user->email], // unique field to check for
            [
                'name' => $user->name,
                'email' => $user->email,
                'nickname' => $user->nickname,
            ]
        );
        
        

        /*'discord_nickname' => $user->nickname,
                'discord_avatar' => $user->avatar,
                'discord_token' => $user->token,
                'discord_refresh_token' => $user->refreshToken,
                'discord_expires_in' => $user->expiresIn,*/
        
        dd($user);
         
    }
}