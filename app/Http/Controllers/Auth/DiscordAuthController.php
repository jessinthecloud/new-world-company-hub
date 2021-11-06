<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\DiscordLoginRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Laravel\Socialite\Facades\Socialite;

use function redirect;

class DiscordAuthController extends Controller
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
     * Handle an incoming authentication request.
     *
     * @param \App\Http\Requests\Auth\DiscordLoginRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DiscordLoginRequest $request)
    {
        // TODO: check user discord token
        
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}