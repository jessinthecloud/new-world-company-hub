<?php

use App\Models\CharacterClass;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})
    ->name('home');

Route::middleware(['guest'])->group(function() {

});

// ###################################
// ## AUTH
// ##
Route::middleware(['auth'])->group(function(){

    // import rosters
    Route::get('/import', [\App\Http\Controllers\ImportRosterController::class, 'create'])
        ->name( 'rosters.import.create' );
    Route::post('/import',[\App\Http\Controllers\ImportRosterController::class, 'store'])
        ->name( 'rosters.import.store' );
    
    // dashboard
    Route::get( '/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
            ->name( 'dashboard' );    
        
        // choose from drop down
        Route::get( '/characters/choose/{action?}', [\App\Http\Controllers\CharactersController::class, 'choose'] )
            ->name( 'characters.choose' );
        Route::get( '/companies/choose', [\App\Http\Controllers\CompaniesController::class, 'choose'] )
            ->name( 'companies.choose' );
        Route::get( '/factions/choose', [\App\Http\Controllers\FactionsController::class, 'choose'] )
            ->name( 'factions.choose' );
        Route::get( '/loadouts/choose', [\App\Http\Controllers\LoadoutsController::class, 'choose'] )
            ->name( 'loadouts.choose' );
        Route::get( '/weapons/choose', [\App\Http\Controllers\WeaponsController::class, 'choose'] )
            ->name( 'weapons.choose' );
        Route::get( '/rosters/choose', [\App\Http\Controllers\RostersController::class, 'choose'] )
            ->name( 'rosters.choose' );
        

        // find char chosen from drop down
        Route::post( '/characters/find', [\App\Http\Controllers\CharactersController::class, 'find'] )
            ->name( 'characters.find' );
        Route::post( '/companies/find', [\App\Http\Controllers\CompaniesController::class, 'find'] )
            ->name( 'companies.find' );
        Route::post( '/factions/find', [\App\Http\Controllers\FactionsController::class, 'find'] )
            ->name( 'factions.find' );
        Route::post( '/loadouts/find', [\App\Http\Controllers\LoadoutsController::class, 'find'] )
            ->name( 'loadouts.find' );
        Route::post( '/weapons/find', [\App\Http\Controllers\WeaponsController::class, 'find'] )
            ->name( 'weapons.find' );
        Route::get( '/rosters/find', [\App\Http\Controllers\RostersController::class, 'choose'] )
            ->name( 'rosters.find' );
        
        // where to go after character is chosen on login
        Route::get( '/characters/{character}/login', [\App\Http\Controllers\CharactersController::class, 'login'] )
            ->name( 'characters.login' );

        /*Route::get('/characters/edit', [\App\Http\Controllers\CharactersController::class, 'edit'])
            ->name('characters.edit.select');
        Route::get('/characters/destroy', [\App\Http\Controllers\CharactersController::class, 'destroy'])
            ->name('characters.destroy.select');*/

        Route::resource( 'characters', \App\Http\Controllers\CharactersController::class )
            ->except( ['create', 'index', 'show'] );
        Route::resource( 'loadouts', \App\Http\Controllers\LoadoutsController::class )
            ->except( ['create', 'index', 'show'] );
        Route::resource( 'companies', \App\Http\Controllers\CompaniesController::class )
            ->except( ['index', 'show'] );
        Route::resource( 'factions', \App\Http\Controllers\FactionsController::class )
            ->except( ['index', 'show'] );
        Route::resource( 'weapons', \App\Http\Controllers\WeaponsController::class )
            ->except( ['index', 'show'] );
        Route::resource( 'rosters', \App\Http\Controllers\RostersController::class )
            ->except( ['index', 'show'] );
            
// ###################################
// ## SUPER ADMIN
// ##
    Route::middleware(['role:super-admin'])->group(function() {
    
        
    }); // end super admin
// ##
// ## END SUPER ADMIN
// #####################################
 
// ###################################
// # ADMIN
// #
 
// ##
// ## END ADMIN
// ################################

// ###################################
// # GOVERNOR
// #
 
// ##
// ## END GOVERNOR
// ################################

// ###################################
// # CONSUL
// #
 
// ##
// ## END CONSUL
// ################################

    Route::resource('characters', \App\Http\Controllers\CharactersController::class)
        ->only(['create', 'index', 'show']);
    Route::resource('loadouts', \App\Http\Controllers\LoadoutsController::class)
        ->only(['create', 'index', 'show']);
    Route::resource('companies', \App\Http\Controllers\CompaniesController::class)
        ->only(['show']);
    Route::resource('companies', \App\Http\Controllers\CompaniesController::class)
        ->only(['index'])->middleware(['role:super-admin|governor']);
    Route::resource('factions', \App\Http\Controllers\FactionsController::class)
        ->only(['index', 'show']);
    Route::resource('weapons', \App\Http\Controllers\WeaponsController::class)
        ->only(['index', 'show']);
    Route::resource('rosters', \App\Http\Controllers\RostersController::class)
        ->only(['index', 'show']);
}); // end auth
// ##
// ## END AUTH
// ################################

// authentication related routes
require __DIR__.'/auth.php';
