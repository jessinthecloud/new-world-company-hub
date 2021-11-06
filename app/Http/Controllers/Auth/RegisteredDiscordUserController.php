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
     */
    public function store(Request $request)
    {
        /**
         * Make the Socialite request to authenticate with Discord
         *
         * @throws ClientException
         * @throws InvalidStateException
         */
        try {
            $discord_user = Socialite::driver( 'discord' )->user();
        } catch(ClientException $e) {
            return redirect(route('register'))
            ->withErrors(['Discord authorization denied. Please try again or enter your information to register.']);
        } catch(InvalidStateException $e) {
            return redirect(route('register'))
            ->withErrors(['Invalid discord request, please try again.']);
        }
        
        $validator = Validator::make(
            ['email' => $discord_user->email],
            [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:discord_data'],
            ],
            [
                'email.unique' => 'This email account already exists. Trying <a class="underline hover:no-underline" href="'.route('login').'">logging in</a> instead',
            ]
        );

        if ($validator->fails()) {
            $request->session()->invalidate();
            return redirect(route('register'))
                ->withErrors($validator);
        }

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
        $data = DiscordData::create(
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