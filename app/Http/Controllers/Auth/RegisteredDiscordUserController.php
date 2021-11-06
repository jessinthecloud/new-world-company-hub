<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\DiscordRegisterRequest;
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(DiscordRegisterRequest $request)
    {
//    dump($request);

        // TODO: check for successful discord auth
        
        /* @throws ClientException */
        /* @throws InvalidStateException */ 
        $discord_user = Socialite::driver('discord')->user();

//dump($discord_user);

        // create eloquent user
        $user = User::firstOrcreate(
            [ 'email' => $discord_user->email, ],
            [
                'name' => $discord_user->name,
                'email' => $discord_user->email,
                'nickname' => $discord_user->nickname,
            ]
        );

//dump($user);

        // save discord data and attach to user
        $data = DiscordData::updateOrcreate(
            [ 'email' => $discord_user->email, ],
            [
                'user_id' => $user->id,
                'name' => $user->name,
                'nickname' => $user->nickname,
                'email' => $user->email,
                'avatar' => $discord_user->avatar,
                'token' => $discord_user->token,
                'refresh_token' => $discord_user->refreshToken,
                'expires_in' => $discord_user->expiresIn,
            ]
        );
        
//dump($data);

        event(new Registered($user));

        if ($discord_user->user['verified'] && $user->markEmailAsVerified()) {
//dump('verified');        
            event(new Verified($user));
        }

        Auth::login($user);
//dd('Success!');
        return redirect(RouteServiceProvider::HOME);

    }
}