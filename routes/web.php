<?php

use App\Models\BaseArmor;
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
    
    // dashboard
    Route::get( '/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
            ->name( 'dashboard' ); 
            
    // where to go after character is chosen on login
        Route::get( '/characters/{character}/login', [\App\Http\Controllers\CharactersController::class, 'login'] )
            ->name( 'characters.login' );
    
// ## RESOURCES
    // GUILD BANK
    Route::resource('guild-banks', \App\Http\Controllers\GuildBanksController::class);
    // FACTION
    Route::resource('factions',\App\Http\Controllers\FactionsController::class)
        ->only(['index', 'show']);
    // COMPANY
    Route::resource('companies', \App\Http\Controllers\CompaniesController::class)
        ->only(['index', 'show']);
    // CHARACTER
    Route::resource('characters', \App\Http\Controllers\CharactersController::class);
    // LOADOUT
    Route::resource('loadouts', \App\Http\Controllers\LoadoutsController::class);
    // BASE ARMOR
    Route::resource('armors', \App\Http\Controllers\BaseArmorsController::class);
    // BASE WEAPON
    Route::resource('weapons',\App\Http\Controllers\BaseWeaponsController::class);
    
// ## CHOOSE
    // choose from drop down
    Route::get( '/characters/choose/{action?}', [\App\Http\Controllers\CharactersController::class, 'choose'] )
        ->name( 'characters.choose' );
    Route::get( '/companies/choose', [\App\Http\Controllers\CompaniesController::class, 'choose'] )
        ->name( 'companies.choose' );
    Route::get( '/factions/choose', [\App\Http\Controllers\FactionsController::class, 'choose'] )
        ->name( 'factions.choose' );
    Route::get( '/loadouts/choose', [\App\Http\Controllers\LoadoutsController::class, 'choose'] )
        ->name( 'loadouts.choose' );
    Route::get( '/weapons/choose', [\App\Http\Controllers\BaseWeaponsController::class, 'choose'] )
        ->name( 'weapons.choose' );
    Route::get( '/rosters/choose', [\App\Http\Controllers\RostersController::class, 'choose'] )
        ->name( 'rosters.choose' );
    
// ## FIND
    // find model chosen from drop down
    Route::post( '/characters/find', [\App\Http\Controllers\CharactersController::class, 'find'] )
        ->name( 'characters.find' );
    Route::post( '/companies/find', [\App\Http\Controllers\CompaniesController::class, 'find'] )
        ->name( 'companies.find' );
    Route::post( '/factions/find', [\App\Http\Controllers\FactionsController::class, 'find'] )
        ->name( 'factions.find' );
    Route::post( '/loadouts/find', [\App\Http\Controllers\LoadoutsController::class, 'find'] )
        ->name( 'loadouts.find' );
    Route::post( '/weapons/find', [\App\Http\Controllers\BaseWeaponsController::class, 'find'] )
        ->name( 'weapons.find' );
    Route::get( '/rosters/find', [\App\Http\Controllers\RostersController::class, 'find'] )
        ->name( 'rosters.find' );
                
            
// ###################################
// ## SUPER ADMIN
// ##
    Route::middleware(['role:super-admin'])->group(function() {
    
        
    }); // end super admin
// ##
// ## END SUPER ADMIN
// #####################################################################
 
// ###################################
// # ADMIN
// #
    Route::middleware(['role:super-admin|admin'])->group(function() {
    
        Route::resource( 'factions', \App\Http\Controllers\FactionsController::class )
            ->except( ['index', 'show'] );
            
        Route::resource( 'companies', \App\Http\Controllers\CompaniesController::class )
            ->except( ['index', 'show', 'edit', 'update'] );
        
    });
// ##
// ## END ADMIN
// ################################################################

// ###################################
// # GOVERNOR
// #
    Route::middleware(['role:super-admin|admin|governor'])->group(function() {
        Route::resource( 'companies', \App\Http\Controllers\CompaniesController::class )
            ->only( ['edit', 'update'] );
    });
// ##
// ## END GOVERNOR
// ################################################################

// ###################################
// # CONSUL
// #
    Route::middleware(['role:super-admin|admin|governor|consul'])->group(function() {
       
        
    });
// ##
// ## END CONSUL
// ################################################################

// ###################################
// # OFFICER
// #
    Route::middleware(['role:super-admin|admin|governor|consul|officer'])->group(function() {
        // import rosters
        Route::get('/import', [\App\Http\Controllers\ImportRosterController::class, 'create'])
            ->name( 'rosters.import.create' );
        Route::post('/import',[\App\Http\Controllers\ImportRosterController::class, 'store'])
            ->name( 'rosters.import.store' );
        
        Route::resource( 'rosters', \App\Http\Controllers\RostersController::class )
            ->except( ['index', 'show'] );
    });
// ##
// ## END OFFICER
// ################################################################

// ###################################
// # SETTLER
// #
    Route::middleware(['role:super-admin|admin|governor|consul|officer|settler'])->group(function() {
        
        Route::resource('rosters', \App\Http\Controllers\RostersController::class)
        ->only(['index', 'show']);
        
    });
// ##
// ## END SETTLER
// ################################################################

    
}); // end auth
// ##
// ## END AUTH
// ################################################################

// authentication related routes
require __DIR__.'/auth.php';
