<?php

namespace App\Http\Controllers;

use App\Models\Characters\Character;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;

class CharacterLoginController extends Controller
{
   /**
     * Set this as primary character for logged-in user
     *
     * @param \Illuminate\Http\Request         $request
     * @param \App\Models\Characters\Character $character
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login( Request $request, Character $character )
    {
        $request->session()->put('character', $character);

        return redirect(RouteServiceProvider::DASHBOARD);
    }
}