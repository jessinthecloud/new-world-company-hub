<?php

use App\Models\BaseArmor;
use App\Models\BaseWeapon;
use App\Models\Perk;
use App\Models\Weapon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get('/reorganize/{thing}', function ($thing) {
    $basedir = __DIR__.'/../storage/app/';
    
    $thong = (in_array($thing, ['weapons','armors','ammo', 'blueprints','consumables','dyes','housing','resources', 'tools'])) ? 'data/items/'.$thing : 'data/'.$thing;
    $fromdir = $basedir.$thong.'/archive';
    
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator( $fromdir, RecursiveDirectoryIterator::SKIP_DOTS  )
    );
//dump($files);
    // combine 50 files into one page file
    $i = 1;
    $total = 0;
    $page=1;
    $data = []; 
    $prev_parent = null;  
    $count = iterator_count($files);
    $files->rewind();
$stop=false;  
    foreach ( $files as $file ) {
        $path = $file->getRealPath();
        $path_of_parent = dirname( $path, 2 );
        $parent_name = Str::afterLast($path_of_parent, '/');
        $full_filename = $file->getFilename();

        $i++;
        $total++;

        /*dump(
//        '-------------',
        'i:'.$i, 
//        'base dir: '.$basedir,
        'from dir: '.$fromdir,
//        $file->getPathinfo(),
//        'path: '.$path,
//        'path of parent: '.$path_of_parent,
        'parent name: '.$parent_name,
        'prev parent: '.$prev_parent,
//        'full filename: '.$full_filename,
        );*/

        if($i>=50 || $total == $count){

$stop = true;

            $filepath = 'json/'.$parent_name.'/'.$parent_name.'-page-'.$page.'.json';
            $page++;
            
            umask( 002 );

/*if($total == $count){
    dump('to dir: '.$filepath, $data);
    die;
}*/
//dd(dirname($basedir.$filepath), storage_path('app/'.$filepath));
            // create sub dirs if they don't exist
            if(!file_exists(dirname($basedir.$filepath))){
                mkdir(dirname($basedir.$filepath), 0777, true);
            }
            
            // store json in one file
            Storage::disk( 'local' )->put(
                $filepath,
                json_encode($data)
            );
            
//            dump("$filepath CREATED");
            
            $data = [];
            $i=0;
        }
        
        $prev_parent = $parent_name;
        
        /*if(is_array(json_decode( file_get_contents( $file->getPathname() ) ))){
            // don't convert already converted
            continue;
//            dd($file->getPathname(), json_decode( file_get_contents( $file->getPathname() ) ));
        }*/
        
        $data []= json_decode( file_get_contents( $file->getPathname() ) )->data;
       

//if($i==0 && $stop) dump($total, $filepath, $data ?? null, '================================');

    } // end foreach file
});


Route::get('/data/{thing}', function (string $thing) {
        $dir = __DIR__ . '/../storage/app/json/'.$thing;
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS )
        );
        foreach ( $files as $file ) {
            $data = json_decode( file_get_contents( $file->getPathname() ) );
            dd( $data[0] );
            
            /*foreach ( $weapons as $weapon ) {
                dump( $weapon );
            }*/
        }
//    return view( 'welcome' );
});

Route::get('/', function () {

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
    Route::get( '/guild-banks/choose', [\App\Http\Controllers\GuildBanksController::class, 'choose'] )
        ->name( 'guild-banks.choose' );
        
    // where to go after character is chosen on login
        Route::get( '/characters/{character}/login', [\App\Http\Controllers\CharactersController::class, 'login'] )
            ->name( 'characters.login' );
    
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
    Route::post( '/rosters/find', [\App\Http\Controllers\RostersController::class, 'find'] )
        ->name( 'rosters.find' );
    Route::post( '/guild-banks/find', [\App\Http\Controllers\GuildBanksController::class, 'find'] )
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
        
        Route::resource('guild-banks', \App\Http\Controllers\GuildBanksController::class)
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
        Route::get('/import', [\App\Http\Controllers\ImportRosterController::class, 'create'])
            ->name( 'rosters.import.create' );
        Route::post('/import',[\App\Http\Controllers\ImportRosterController::class, 'store'])
            ->name( 'rosters.import.store' );
        
        Route::resource( 'rosters', \App\Http\Controllers\RostersController::class )
            ->except( ['index', 'show'] );
            
        Route::resource('guild-banks', \App\Http\Controllers\GuildBanksController::class)
            ->except(['index', 'show', 'destroy']);
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
        
        // GUILD BANK
        Route::resource('guild-banks', \App\Http\Controllers\GuildBanksController::class)
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
