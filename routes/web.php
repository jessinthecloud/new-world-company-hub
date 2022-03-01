<?php

use App\Http\Controllers\Admin\FactionsController;
use App\Http\Controllers\Characters\CharacterLoginController;
use App\Http\Controllers\Characters\CharactersController;
use App\Http\Controllers\Characters\LoadoutsController;
use App\Http\Controllers\Companies\CompaniesController;
use App\Http\Controllers\Companies\CompanyLoginController;
use App\Http\Controllers\Companies\CompanyMembersController;
use App\Http\Controllers\Companies\ImportRosterController;
use App\Http\Controllers\Companies\RostersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GearCheckController;
use App\Http\Controllers\Items\ArmorsController;
use App\Http\Controllers\Items\CompanyInventoryController;
use App\Http\Controllers\Items\WeaponsController;
use App\Http\Controllers\WarBoards\WarBoardsController;
use App\Models\Items\OldBaseArmor;
use App\Models\Items\OldBaseWeapon;
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

Route::get( '/', function () {
    if ( Auth::user() !== null ) {
        return redirect( 'dashboard' );
    }
    return view( 'auth.login' );
} )
    ->name( 'home' );

Route::middleware( ['guest'] )->group( function () {
} );

// ###################################
// ## AUTH
// ##

Route::middleware( ['auth'] )->group( function () {
// must have company on login
    Route::get( '/companies/{company}/login', [
        CompanyLoginController::class,
        'login',
    ] )
        ->name( 'companies.login.login' );
    Route::get( '/companies/login/choose', [
        CompanyLoginController::class,
        'choose',
    ] )
        ->name( 'companies.login.choose' );
} );

Route::middleware( ['auth', 'company',] )->group( function () {
// must have character on login
    Route::get( '/characters/{character}/login',
                [CharacterLoginController::class, 'login']
    )
        ->name( 'characters.login.login' );
    Route::get( '/characters/login/choose',
                [CharacterLoginController::class, 'choose']
    )
        ->name( 'characters.login.choose' );
    Route::get( '/characters/login/create',
                [CharacterLoginController::class, 'create']
    )
        ->name( 'characters.login.create' );
    Route::post( '/characters/login',
                 [CharacterLoginController::class, 'store']
    )
        ->name( 'characters.login.store' );
} );

Route::middleware( ['auth', 'company', 'character',] )->group( function () {
// must have loadout on login
    Route::get( '/loadouts/create', [LoadoutsController::class, 'create']
    )
        ->name( 'loadouts.create' );
    Route::post( '/loadouts', [LoadoutsController::class, 'store']
    )
        ->name( 'loadouts.store' );
} );

Route::middleware( ['auth', 'company', 'character', /*'loadout'*/] )->group( function () {
    // dashboard
    Route::get( '/dashboard', [DashboardController::class, 'index'] )
        ->name( 'dashboard' );

// ## RESOURCES

    Route::get( '/base-weapons/{baseWeapon}', function ( OldBaseWeapon $baseWeapon ) {
        return new \App\Http\Resources\BaseWeaponResource( $baseWeapon->load( 'perks' ) );
    } )
        ->name( 'base-weapons.show' );

    Route::get( '/base-weapons', function () {
        $weapons = OldBaseWeapon::with('perks' )->orderBy('name' )->orderBy('tier' )->distinct()->get();

        return new \App\Http\Resources\BaseWeaponCollection( $weapons );
    } )
        ->name( 'base-weapons.index' );

    Route::get( '/base-armors/{baseArmor}', function ( OldBaseArmor $baseArmor ) {
        return new \App\Http\Resources\BaseArmorResource( $baseArmor->load( 'perks' ) );
    } )
        ->name( 'base-armors.show' );

    Route::get( '/base-armors', function () {
        $armors = OldBaseArmor::with('perks' )->orderBy('name' )->orderBy('tier' )->distinct()->get();

        return new \App\Http\Resources\BaseArmorCollection( $armors );
    } )
        ->name( 'base-armors.index' );


    // BASE ARMOR
//    Route::resource( 'base-armors', \App\Http\Controllers\Items\BaseArmorsController::class);
//    // BASE WEAPON
//    Route::resource( 'base-weapons', \App\Http\Controllers\Items\BaseWeaponsController::class);


// ###################################
// ## SUPER ADMIN
// ##
    Route::middleware( ['role:super-admin'] )->group( function () {
        // convert all existing items to Inventory Items 
        Route::get( '/items/convert',
                    [CompanyInventoryController::class, 'convertAll'] )
            ->name( 'companies.inventory.convertAll' );
    } ); // end super admin
// ##
// ## END SUPER ADMIN
// #####################################################################

// ###################################
// # ADMIN
// #
    Route::middleware( ['role:super-admin|admin'] )->group( function () {
        Route::resource( 'factions', FactionsController::class )
            ->except( ['index', 'show'] );

        Route::resource( 'companies', CompaniesController::class )
            ->except( ['index', 'show', 'edit', 'update'] );
    } );
// ##
// ## END ADMIN
// ################################################################

// ###################################
// # BANKER
// #
    Route::middleware( ['role:super-admin|admin|banker'] )->group( function () {
        // create form for inventory item for specific company
        Route::get( '/companies/{company}/inventory/create',
                    [CompanyInventoryController::class, 'create'] )
            ->name( 'companies.inventory.create' );
        // store inventory item for specific company
        Route::post( '/companies/{company}/inventory',
                     [CompanyInventoryController::class, 'store'] )
            ->name( 'companies.inventory.store' );
        // edit form for specific inventory item for specific company
        Route::get( '/companies/{company}/inventory/{inventoryItem}/edit',
                    [CompanyInventoryController::class, 'edit'] )
            ->name( 'companies.inventory.edit' );
        // update specific inventory item for specific company
        Route::put( '/companies/{company}/inventory/{inventoryItem}',
                    [CompanyInventoryController::class, 'update'] )
            ->name( 'companies.inventory.update' );
        // delete specific inventory item from specific company
        Route::delete( '/companies/{company}/inventory/{inventoryItem}',
                       [CompanyInventoryController::class, 'destroy'] )
            ->name( 'companies.inventory.destroy' );
    } );
// ##
// ## END BANKER
// ################################################################

// ###################################
// # GOVERNOR
// #
    Route::middleware( ['role:super-admin|admin|governor'] )->group( function () {
        Route::resource( 'companies', CompaniesController::class )
            ->only( ['edit', 'update'] );
    } );
// ##
// ## END GOVERNOR
// ################################################################

// ###################################
// # CONSUL
// #
    Route::middleware( ['role:super-admin|admin|governor|consul'] )->group( function () {
        // approve gear check
        Route::post( '/loadouts/approve/{loadout}', [GearCheckController::class, 'approve'] )
            ->name( 'loadouts.approve' );
        
        /*
         * WAR BOARDS
         */
        // create form for war board for specific company
        Route::get( '/war-boards/create', [WarBoardsController::class, 'create'] )
            ->name( 'war-boards.create' );
        // store war board for specific company
        Route::post( '/war-boards', [WarBoardsController::class, 'store'] )
            ->name( 'war-boards.store' );
        /*// edit form for specific war board for specific company
        Route::get( '/war-boards/{warBoard}/edit', [WarBoardsController::class, 'edit'] )
            ->name( 'war-boards.edit' );
        // update specific war board for specific company
        Route::put( '/war-boards/{warBoard}', [WarBoardsController::class, 'update'] )
            ->name( 'war-boards.update' );
        // delete specific war board from specific company
        Route::delete( '/war-boards/{warBoard}', [WarBoardsController::class, 'destroy'] )
            ->name( 'war-boards.destroy' );*/
    } );
// ##
// ## END CONSUL
// ################################################################

// ###################################
// # OFFICER
// #
    Route::middleware( ['role:super-admin|admin|governor|consul|officer'] )->group( function () {
        // import rosters
        Route::get( '/import', [ImportRosterController::class, 'create'] )
            ->name( 'rosters.import.create' );
        Route::post( '/import', [ImportRosterController::class, 'store'] )
            ->name( 'rosters.import.store' );

        // export full company roster
        Route::get( '/companies/{company}/export', [CompanyMembersController::class, 'export'] )
            ->name( 'companies.company.export' );            

        Route::resource( 'rosters', RostersController::class )
            ->except( ['create', 'index', 'show'] );

        Route::delete( 'companies/{company}/member/{character}', [CompanyMembersController::class, 'destroy'] )
            ->name( 'company.members.destroy' );
    } );
// ##
// ## END OFFICER
// ################################################################

// ###################################
// # SETTLER
// #
    Route::middleware( ['role:super-admin|admin|governor|consul|officer|breakpoint-member'] )->group( function () {
        // view all of specific company's inventory
        Route::get( '/companies/{company}/inventory',
                    [CompanyInventoryController::class, 'index'] )
            ->name( 'companies.inventory.index' );

        Route::get( '/weapons/{weapon}', [WeaponsController::class, 'show'] )
            ->name( 'weapons.show' );

        Route::get( '/armors/{armor}', [ArmorsController::class, 'show'] )
            ->name( 'armors.show' );

        // FACTION
        Route::resource( 'factions', FactionsController::class )
            ->only( ['index', 'show'] );
        // COMPANY
        Route::resource( 'companies', CompaniesController::class )
            ->only( ['index', 'show'] );

        // CHARACTER
        Route::resource( 'characters', CharactersController::class );

        // LOADOUT
        Route::resource( 'loadouts', LoadoutsController::class )
            ->except( ['index', 'create', 'store'] );
        Route::get( '/loadouts/choose', [LoadoutsController::class, 'choose'] )
            ->name( 'loadouts.choose' );
        Route::post( '/loadouts/find', [LoadoutsController::class, 'find'] )
            ->name( 'loadouts.find' );

        Route::resource( 'rosters', RostersController::class )
            ->only( ['index', 'show'] );
        
        // gear check approval removal (could be from editing)
        Route::delete( '/loadouts/{loadout}', [GearCheckController::class, 'destroy'] )
            ->name( 'loadouts.gear-check.destroy' );
            
        // WAR BOARD
        Route::get( '/war-boards/{warBoard}', [WarBoardsController::class, 'show'] )
            ->name( 'war-boards.show' );
        
// ## CHOOSE
        // choose from drop down
        Route::get( '/characters/choose/{action?}', [CharactersController::class, 'choose'] )
            ->name( 'characters.choose' );
        Route::get( '/companies/choose', [CompaniesController::class, 'choose'] )
            ->name( 'companies.choose' );
        Route::get( '/factions/choose', [FactionsController::class, 'choose'] )
            ->name( 'factions.choose' );
        Route::get( '/base-weapons/choose', [\App\Http\Controllers\Items\BaseWeaponsController::class, 'choose'] )
            ->name( 'base-weapons.choose' );
        Route::get( '/rosters/choose', [RostersController::class, 'choose'] )
            ->name( 'rosters.choose' );

// ## FIND
        // find model chosen from drop down
        Route::post( '/characters/find', [CharactersController::class, 'find'] )
            ->name( 'characters.find' );
        Route::post( '/companies/find', [CompaniesController::class, 'find'] )
            ->name( 'companies.find' );
        Route::post( '/factions/find', [FactionsController::class, 'find'] )
            ->name( 'factions.find' );

        Route::post( '/base-weapons/find', [\App\Http\Controllers\Items\BaseWeaponsController::class, 'find'] )
            ->name( 'base-weapons.find' );
        Route::post( '/rosters/find', [RostersController::class, 'find'] )
            ->name( 'rosters.find' );
    } );
// ##
// ## END SETTLER
// ################################################################


} ); // end auth
// ##
// ## END AUTH
// ################################################################

// authentication related routes
require __DIR__ . '/auth.php';
