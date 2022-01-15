<?php

namespace App\Providers;

use App\GuildBank;
use App\Http\Controllers\Companies\GuildBanksController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    /*dd(Auth::check());
        // user isn't authenticated yet at this point...
        $company = Auth::check() ? Auth::user()->company() : null;
        $guildBank = new GuildBank($company);
        
        $this->app->when(GuildBanksController::class)
          ->needs(GuildBank::class)
          ->give(function () use ($guildBank) {
              return $guildBank;
          });*/
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
