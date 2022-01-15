<?php

use App\Models\BaseArmor;
use App\Models\BaseWeapon;
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
//dump(Weapon::with('company')->first());
    return view( 'welcome' );
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
    
// ## RESOURCES

Route::get( '/base-weapons/{baseWeapon}', function(BaseWeapon $baseWeapon){
    return new \App\Http\Resources\BaseWeaponResource($baseWeapon->load('perks'));
} )
->name( 'base-weapons.show' );

Route::get( '/base-weapons', function(){

    $weapons = BaseWeapon::with('perks')->orderBy('name')->orderBy('tier')->distinct()->get();
        
    return new \App\Http\Resources\BaseWeaponCollection($weapons);
} )
->name( 'base-weapons.index' );

Route::get( '/base-armors/{baseArmor}', function(BaseArmor $baseArmor){
    return new \App\Http\Resources\BaseArmorResource($baseArmor->load('perks'));
} )
->name( 'base-armors.show' );

Route::get( '/base-armors', function(){

    $armors = BaseArmor::with('perks')->orderBy('name')->orderBy('tier')->distinct()->get();
        
    return new \App\Http\Resources\BaseArmorCollection($armors);
} )
->name( 'base-armors.index' );

    // FACTION
    Route::resource( 'factions', \App\Http\Controllers\FactionsController::class)
        ->only(['index', 'show']);
    // COMPANY
    Route::resource( 'companies', \App\Http\Controllers\Companies\CompaniesController::class)
        ->only(['index', 'show']);
    // CHARACTER
    Route::resource( 'characters', \App\Http\Controllers\CharactersController::class);
    // LOADOUT
    Route::resource( 'loadouts', \App\Http\Controllers\LoadoutsController::class);
    // BASE ARMOR
    Route::resource( 'armors', \App\Http\Controllers\Items\BaseArmorsController::class);
    // BASE WEAPON
    Route::resource( 'weapons', \App\Http\Controllers\Items\BaseWeaponsController::class);
    
// ## CHOOSE
    // choose from drop down
    Route::get( '/characters/choose/{action?}', [\App\Http\Controllers\CharactersController::class, 'choose'] )
        ->name( 'characters.choose' );
    Route::get( '/companies/choose', [\App\Http\Controllers\Companies\CompaniesController::class, 'choose'] )
        ->name( 'companies.choose' );
    Route::get( '/factions/choose', [\App\Http\Controllers\FactionsController::class, 'choose'] )
        ->name( 'factions.choose' );
    Route::get( '/loadouts/choose', [\App\Http\Controllers\LoadoutsController::class, 'choose'] )
        ->name( 'loadouts.choose' );
    Route::get( '/weapons/choose', [\App\Http\Controllers\Items\BaseWeaponsController::class, 'choose'] )
        ->name( 'weapons.choose' );
    Route::get( '/rosters/choose', [\App\Http\Controllers\Companies\RostersController::class, 'choose'] )
        ->name( 'rosters.choose' );
    Route::get( '/guild-banks/choose', [\App\Http\Controllers\Companies\GuildBanksController::class, 'choose'] )
        ->name( 'guild-banks.choose' );
        
    // where to go after character is chosen on login
        Route::get( '/characters/{character}/login', [\App\Http\Controllers\CharactersController::class, 'login'] )
            ->name( 'characters.login' );
    
// ## FIND
    // find model chosen from drop down
    Route::post( '/characters/find', [\App\Http\Controllers\CharactersController::class, 'find'] )
        ->name( 'characters.find' );
    Route::post( '/companies/find', [\App\Http\Controllers\Companies\CompaniesController::class, 'find'] )
        ->name( 'companies.find' );
    Route::post( '/factions/find', [\App\Http\Controllers\FactionsController::class, 'find'] )
        ->name( 'factions.find' );
    Route::post( '/loadouts/find', [\App\Http\Controllers\LoadoutsController::class, 'find'] )
        ->name( 'loadouts.find' );
    Route::post( '/weapons/find', [\App\Http\Controllers\Items\BaseWeaponsController::class, 'find'] )
        ->name( 'weapons.find' );
    Route::post( '/rosters/find', [\App\Http\Controllers\Items\RostersController::class, 'find'] )
        ->name( 'rosters.find' );
    Route::post( '/guild-banks/find', [\App\Http\Controllers\Companies\GuildBanksController::class, 'find'] )
        ->name( 'guild-banks.find' );
                
            
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
            
        Route::resource( 'companies', \App\Http\Controllers\Companies\CompaniesController::class )
            ->except( ['index', 'show', 'edit', 'update'] );
        
    });
// ##
// ## END ADMIN
// ################################################################

// ###################################
// # GOVERNOR
// #
    Route::middleware(['role:super-admin|admin|governor'])->group(function() {
        Route::resource( 'companies', \App\Http\Controllers\Companies\CompaniesController::class )
            ->only( ['edit', 'update'] );
        
        Route::resource( 'guild-banks', \App\Http\Controllers\Companies\GuildBanksController::class)
            ->only(['destroy']);
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
        Route::get('/import', [\App\Http\Controllers\Companies\ImportRosterController::class, 'create'])
            ->name( 'rosters.import.create' );
        Route::post('/import',[\App\Http\Controllers\Companies\ImportRosterController::class, 'store'])
            ->name( 'rosters.import.store' );
        
        Route::resource( 'rosters', \App\Http\Controllers\Companies\RostersController::class )
            ->except( ['index', 'show'] );
            
        Route::resource( 'guild-banks', \App\Http\Controllers\Companies\GuildBanksController::class)
            ->except(['index', 'show', 'destroy']);
    });
// ##
// ## END OFFICER
// ################################################################

// ###################################
// # SETTLER
// #
    Route::middleware(['role:super-admin|admin|governor|consul|officer|settler'])->group(function() {
        
        Route::resource( 'rosters', \App\Http\Controllers\Companies\RostersController::class)
        ->only(['index', 'show']);
        
        // GUILD BANK
        Route::resource( 'guild-banks', \App\Http\Controllers\Companies\GuildBanksController::class)
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
