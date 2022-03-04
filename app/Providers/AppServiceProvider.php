<?php

namespace App\Providers;

use App\Models\Companies\Company;
use App\Models\ItemOwner;
use App\Policies\Companies\CompanyPolicy;
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
        /*$this->app->when(CompanyPolicy::class)
            ->needs(ItemOwner::class)
            ->give(function () {
                return Company::class;
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
