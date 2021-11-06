<?php

namespace App\Http\Requests;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Contracts\User as DiscordUser;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class DiscordRegisterRequest extends FormRequest
{
    /**
     * The route that users should be redirected to if validation fails.
     *
     * @var string
     */
    protected $redirectRoute = 'login';
    
    public ?DiscordUser $discord_user;

    /**
     * Prepare the data for validation.
     * Is called prior to authorization.
     * 
     * @return 
     */
    protected function prepareForValidation()
    {
        $this->discord_user = $this->session()->get('discord_user');
    
        $this->merge([
            'email' => $this->discord_user->email,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:discord_data'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.unique' => 'This email account already exists. Trying logging in instead',
        ];
    }
}