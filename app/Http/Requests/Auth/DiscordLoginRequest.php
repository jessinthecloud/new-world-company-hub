<?php

namespace App\Http\Requests\Auth;

use App\Models\DiscordData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class DiscordLoginRequest extends LoginRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'exists:users', 'exists:discord_data'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();
        
        // TODO: make sure attempt is done with discord token
        $token = DiscordData::select('token')->where('email', $this->only('email'))->first();
dump($token);
        $user = Socialite::driver('discord')->userFromToken($token);
ddd($user);

        if ( !isset($user) ) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }
        
        Auth::login($user, $this->boolean('remember'));

        RateLimiter::clear($this->throttleKey());
    }
}