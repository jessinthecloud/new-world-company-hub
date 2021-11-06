<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\DiscordAuthorizedRequest;
use App\Http\Requests\DiscordRegisterRequest;
use App\Models\DiscordData;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class RegisteredDiscordUserController extends Controller
{

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
            return redirect( route( 'discord.store' ) )
                ->with([
                    'discord_user' => Socialite::driver( 'discord' )->user()
                ]);
        } catch ( ClientException $e ) {
            return redirect( route( 'register' ) )
                ->withErrors( ['Discord authorization denied. Please try again or enter your information to register.'] );
        } catch ( InvalidStateException $e ) {
            return redirect( route( 'register' ) )
                ->withErrors( ['Invalid discord request, please try again.'] );
        }
    }

    /**
     * Handle and store the user account w/ discord info   
     * 
     * @param \App\Http\Requests\DiscordRegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DiscordRegisterRequest $request)
    {
        // find or create eloquent user
        // user account may exist and should be tied to discord data
        $user = User::firstOrcreate(
            [ 'email' => $request->discord_user->email, ],
            [
                'name' => $request->discord_user->name,
                'email' => $request->discord_user->email,
                'nickname' => $request->discord_user->nickname,
            ]
        );

        // save discord data and tie to user
        $data = DiscordData::create(
            [
                'user_id' => $user->id,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'email' => $user->email,
                'avatar' => $request->discord_user->avatar,
                'token' => $request->discord_user->token,
                'refresh_token' => $request->discord_user->refreshToken,
                'expires_in' => $request->discord_user->expiresIn,
            ]
        );

        event(new Registered($user));

        if ($request->discord_user->user['verified'] && $user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);

    }
}