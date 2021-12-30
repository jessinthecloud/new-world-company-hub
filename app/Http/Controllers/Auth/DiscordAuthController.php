<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\DiscordData;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

use Laravel\Socialite\Two\InvalidStateException;

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
        // TODO: check for remember me before going to discord ?
        
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws ClientException
     * @throws InvalidStateException
     */
    public function callback(Request $request)
    {
        try {
            $discordUser = Socialite::driver( 'discord' )->user();
//dump($discordUser);
            // find or create eloquent user with this discord name
            $user = User::where('discord_name',  $discordUser->nickname)->get();
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
            }
            else{
                $user = $user->sole()->update([
                    'name' => $discordUser->name,
                    'email' => $discordUser->email,
                    'discord_name' => $discordUser->nickname,
                ]);
                // may not need this
                $user->save();
            }
            
//dd($user);
            // update or save discord data and tie to user
            $data = DiscordData::updateOrCreate(
                [ 'email' => $discordUser->email, ],
                [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'nickname' => $discordUser->nickname,
                    'email' => $user->email,
                    'avatar' => $discordUser->avatar,
                    'token' => $discordUser->token,
                    'refresh_token' => $discordUser->refreshToken,
                    'expires_in' => $discordUser->expiresIn,
                ]
            );

            event(new Registered($user));

            if ($discordUser->user['verified'] && $user->markEmailAsVerified()) {
                event(new Verified($user));
            }

            Auth::login($user, true);

            return redirect(RouteServiceProvider::DASHBOARD);
           
        } catch ( ClientException $e ) {
        
            return redirect( route( 'login' ) )
            ->withErrors( ['Discord authorization denied. Please try again or enter your information to register.'] );
        
        } catch ( InvalidStateException $e ) {
        
            return redirect( route( 'login' ) )
            ->withErrors( ['Invalid discord request, please try again.'] );
        
        }
    }
}