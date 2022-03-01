<?php

namespace App\Providers;

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
        'App\CompanyInventory'            => 'App\Policies\Companies\CompanyInventoryPolicy',
        'App\Models\Characters\Character'   => 'App\Policies\Characters\CharacterPolicy',
        'App\Models\Companies\Company'   => 'App\Policies\Companies\CompanyPolicy',

        'App\Models\Events\Roster'   => 'App\Policies\Events\RosterPolicy',
        'App\Models\Items\Loadout'   => 'App\Policies\Items\LoadoutPolicy',
        'App\Models\Items\OldWeapon' => 'App\Policies\Items\WeaponPolicy',
        'App\Models\Events\WarBoard' => 'App\Policies\Events\WarBoardPolicy',
        
        // Policies with conventional naming are auto-registered here
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
        Gate::before( function ( $user, $ability ) {
            return ($user->hasRole( ['super-admin', 'dev'] ) && in_array($user->email, [
                'epwnaz@gmail.com',
                // more emails
            ])) ? true : null;
        } );
    }
}
