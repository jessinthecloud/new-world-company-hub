<?php

namespace App\Providers;

use App\Policies\EventPolicy;
use App\Policies\PositionPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\GuildBank' => 'App\Policies\GuildBankPolicy',
        // Policies with conventional naming are auto-registered here
        // Company, Roster, Event
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        /**
         * Implicitly grant "Super Admin" role all permissions
         * This works in the app by using gate-related functions
         * like auth()->user->can() and @can()
         * 
         * Gate::before rules need to return null rather than false,
         * else it will interfere with normal policy operation
         * 
         * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/super-admin
         */
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}
