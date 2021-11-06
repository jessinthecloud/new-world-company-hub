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
    public DiscordUser $discord_user;
   /* 
    public function __construct(
    array $query = [],
    array $request = [],
    array $attributes = [],
    array $cookies = [],
    array $files = [],
    array $server = [],
    $content = null
    )
    {
        parent::__construct( $query, $request, $attributes, $cookies, $files, $server, $content );
//ddd($this, $_REQUEST, $_SERVER);
    }*/

    /**
     * Prepare the data for validation.
     * Is called prior to authorization.
     * 
     * @return 
     */
    protected function prepareForValidation()
    {
        $this->discord_user = $this->session()->get('discord_user');
//        ddd('prepare', $this->session()->get('discord_user'), $this->discord_user);
        /*    
                $result = $this->setDiscordUser();
        
                if($result !== true){
                    // if we get here without a user, Discord Auth failed
        //dump($result);
        //ddd($result->getSession(), $result->getSession()->get('errors')->all());
        
                    $errors = $result->getSession()->get('errors')->all();
                    $result->getSession()->invalidate();
                                
                    return redirect('/register')
                        ->withErrors($errors);
                }*/
    
        $this->merge([
            'email' => $this->discord_user->email,
        ]);
    }

    /**
     * Make the Socialite request to authenticate with Discord
     *
     * @throws ClientException
     * @throws InvalidStateException
     *
    protected function setDiscordUser()
    {
        try {
            $this->discord_user = Socialite::driver( 'discord' )->user();
            return true;
        } catch(ClientException $e) {
            return redirect(route('register'))
                ->withErrors(['Discord authorization denied. Please try again or enter your registration information.']);
        } catch(InvalidStateException $e) {
            return redirect(route('register'))
                ->withErrors(['Invalid discord request, please try again.']);
        }
    }
    // */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:discord_data'],
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
            'email.unique' => 'This email already exists. Trying logging in instead: '.route('login'),
        ];
    }
}