<?php

use App\Http\Controllers\Items\CompanyInventoryController;
use App\Models\Items\BaseArmor;
use App\Models\Items\BaseWeapon;
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
    if(Auth::check()) {
        return redirect( 'dashboard' );
    }
    return view( 'auth.login' );
})
->name('home');

Route::middleware(['guest'])->group(function() {

});

// ###################################
// ## AUTH
// ##

Route::middleware(['auth'])->group(function() {
// character is chosen on login
    Route::get( '/companies/{company}/login', [
        \App\Http\Controllers\Companies\CompanyLoginController::class, 'login'
    ])
        ->name( 'companies.login.login' );
    Route::get( '/companies/login/choose', [
        \App\Http\Controllers\Companies\CompanyLoginController::class, 'choose'
    ])
        ->name( 'companies.login.choose' );
});

Route::middleware(['auth', 'company'])->group(function() {
// character is chosen on login
    Route::get( '/characters/{character}/login',
                [\App\Http\Controllers\Characters\CharacterLoginController::class, 'login']
    )
        ->name( 'characters.login.login' );
    Route::get( '/characters/login/choose',
                [\App\Http\Controllers\Characters\CharacterLoginController::class, 'choose']
    )
        ->name( 'characters.login.choose' );
    Route::get( '/characters/login/create',
                [\App\Http\Controllers\Characters\CharacterLoginController::class, 'create']
    )
        ->name( 'characters.login.create' );
    Route::post( '/characters/login',
                [\App\Http\Controllers\Characters\CharacterLoginController::class, 'store']
    )
        ->name( 'characters.login.store' );
});

Route::middleware(['auth', 'company', 'character'])->group(function(){
    
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
    
    
    // BASE ARMOR
//    Route::resource( 'base-armors', \App\Http\Controllers\Items\BaseArmorsController::class);
//    // BASE WEAPON
//    Route::resource( 'base-weapons', \App\Http\Controllers\Items\BaseWeaponsController::class);
    
            
// ###################################
// ## SUPER ADMIN
// ##
    Route::middleware(['role:super-admin'])->group(function() {
        // convert all existing items to Inventory Items 
        Route::get( '/items/convert', 
            [CompanyInventoryController::class, 'convertAll'] )
            ->name('companies.inventory.convertAll')
        ;
        
    }); // end super admin
// ##
// ## END SUPER ADMIN
// #####################################################################
 
// ###################################
// # ADMIN
// #
    Route::middleware(['role:super-admin|admin'])->group(function() {
    
        Route::resource( 'factions', \App\Http\Controllers\Admin\FactionsController::class )
            ->except( ['index', 'show'] );
            
        Route::resource( 'companies', \App\Http\Controllers\Companies\CompaniesController::class )
            ->except( ['index', 'show', 'edit', 'update'] );
        
    });
// ##
// ## END ADMIN
// ################################################################

// ###################################
// # BANKER
// #
    Route::middleware(['role:super-admin|admin|banker'])->group(function() {
        // view all of specific company's inventory
        Route::get( '/companies/{company}/inventory', 
            [CompanyInventoryController::class, 'index'] )
            ->name('companies.inventory.index')
        ;
        // create form for inventory item for specific company
        Route::get( '/companies/{company}/inventory/create', 
            [CompanyInventoryController::class, 'create'] )
            ->name('companies.inventory.create')
        ;
        // store inventory item for specific company
        Route::post( '/companies/{company}/inventory', 
            [CompanyInventoryController::class, 'store'] )            
            ->name('companies.inventory.store')
        ;
        // edit form for specific inventory item for specific company
        Route::get( '/companies/{company}/inventory/{inventoryItem}/edit', 
            [CompanyInventoryController::class, 'edit'] )
            ->name('companies.inventory.edit')
        ;
        // update specific inventory item for specific company
        Route::put( '/companies/{company}/inventory/{inventoryItem}', 
            [CompanyInventoryController::class, 'update'] )
            ->name('companies.inventory.update')
        ;
        // delete specific inventory item from specific company
        Route::delete( '/companies/{company}/inventory/{inventoryItem}', 
            [CompanyInventoryController::class, 'destroy'] )
            ->name('companies.inventory.destroy')
        ;
    });
// ##
// ## END BANKER
// ################################################################

// ###################################
// # GOVERNOR
// #
    Route::middleware(['role:super-admin|admin|governor'])->group(function() {
        Route::resource( 'companies', \App\Http\Controllers\Companies\CompaniesController::class )
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
        Route::get('/import', [\App\Http\Controllers\Companies\ImportRosterController::class, 'create'])
            ->name( 'rosters.import.create' );
        Route::post('/import',[\App\Http\Controllers\Companies\ImportRosterController::class, 'store'])
            ->name( 'rosters.import.store' );
        
        Route::resource( 'rosters', \App\Http\Controllers\Companies\RostersController::class )
            ->except( ['create', 'index', 'show'] );
            
        Route::delete( 'companies/{company}/member/{character}', [\App\Http\Controllers\Companies\CompanyMembersController::class, 'destroy'])
            ->name('company.members.destroy');
    });
// ##
// ## END OFFICER
// ################################################################

// ###################################
// # SETTLER
// #
    Route::middleware(['role:super-admin|admin|governor|consul|officer|breakpoint-member'])->group(function() {
        
        Route::get( '/weapons/{weapon}', [\App\Http\Controllers\Items\WeaponsController::class, 'show'] )
        ->name( 'weapons.show' );
        
        Route::get( '/armors/{armor}', [\App\Http\Controllers\Items\ArmorsController::class, 'show'] )
        ->name( 'armors.show' );
    
        // FACTION
        Route::resource( 'factions', \App\Http\Controllers\Admin\FactionsController::class)
            ->only(['index', 'show']);
        // COMPANY
        Route::resource( 'companies', \App\Http\Controllers\Companies\CompaniesController::class)
            ->only(['index', 'show']);
            
        // CHARACTER
        Route::resource( 'characters', \App\Http\Controllers\Characters\CharactersController::class);
        // LOADOUT
        Route::resource( 'loadouts', \App\Http\Controllers\Characters\LoadoutsController::class);
        
        Route::resource( 'rosters', \App\Http\Controllers\Companies\RostersController::class)
            ->only(['index', 'show']);
        
        
// ## CHOOSE
    // choose from drop down
    Route::get( '/characters/choose/{action?}', [\App\Http\Controllers\Characters\CharactersController::class, 'choose'] )
        ->name( 'characters.choose' );
    Route::get( '/companies/choose', [\App\Http\Controllers\Companies\CompaniesController::class, 'choose'] )
        ->name( 'companies.choose' );
    Route::get( '/factions/choose', [\App\Http\Controllers\Admin\FactionsController::class, 'choose'] )
        ->name( 'factions.choose' );
    Route::get( '/loadouts/choose', [\App\Http\Controllers\Characters\LoadoutsController::class, 'choose'] )
        ->name( 'loadouts.choose' );
    Route::get( '/base-weapons/choose', [\App\Http\Controllers\Items\BaseWeaponsController::class, 'choose'] )
        ->name( 'base-weapons.choose' );
    Route::get( '/rosters/choose', [\App\Http\Controllers\Companies\RostersController::class, 'choose'] )
        ->name( 'rosters.choose' );
    
// ## FIND
    // find model chosen from drop down
    Route::post( '/characters/find', [\App\Http\Controllers\Characters\CharactersController::class, 'find'] )
        ->name( 'characters.find' );
    Route::post( '/companies/find', [\App\Http\Controllers\Companies\CompaniesController::class, 'find'] )
        ->name( 'companies.find' );
    Route::post( '/factions/find', [\App\Http\Controllers\Admin\FactionsController::class, 'find'] )
        ->name( 'factions.find' );
    Route::post( '/loadouts/find', [\App\Http\Controllers\Characters\LoadoutsController::class, 'find'] )
        ->name( 'loadouts.find' );
    Route::post( '/base-weapons/find', [\App\Http\Controllers\Items\BaseWeaponsController::class, 'find'] )
        ->name( 'base-weapons.find' );
    Route::post( '/rosters/find', [\App\Http\Controllers\Companies\RostersController::class, 'find'] )
        ->name( 'rosters.find' );
        
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
