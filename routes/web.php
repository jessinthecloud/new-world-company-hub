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
});

Route::get('/dashboard', function () {
    return view('dashboard', ['form_action'=>route('dashboard')]);
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function(){

    // choose from drop down
    Route::get('/characters/choose', [\App\Http\Controllers\CharactersController::class, 'choose'])->name('characters.choose');
    Route::get('/companies/choose', [\App\Http\Controllers\CompaniesController::class, 'choose'])->name('companies.choose');
    Route::get('/factions/choose', [\App\Http\Controllers\FactionsController::class, 'choose'])->name('factions.choose');
    Route::get('/loadouts/choose', [\App\Http\Controllers\LoadoutsController::class, 'choose'])->name('loadouts.choose');
    
    // find char chosen from drop down
    Route::post('/characters/find', [\App\Http\Controllers\CharactersController::class, 'find'])->name('characters.find');
    Route::post('/companies/find', [\App\Http\Controllers\CompaniesController::class, 'find'])->name('companies.find');
    Route::post('/factions/find', [\App\Http\Controllers\FactionsController::class, 'find'])->name('factions.find');
    Route::post('/loadouts/find', [\App\Http\Controllers\LoadoutsController::class, 'find'])->name('loadouts.find');
    
    /*Route::get('/characters/edit', [\App\Http\Controllers\CharactersController::class, 'edit'])->name('characters.edit.select');
    Route::get('/characters/destroy', [\App\Http\Controllers\CharactersController::class, 'destroy'])->name('characters.destroy.select');*/
    
    Route::resources([
        'characters' => \App\Http\Controllers\CharactersController::class,
        'loadouts' => \App\Http\Controllers\LoadoutsController::class,
        'companies' => \App\Http\Controllers\CompaniesController::class,
        'factions' => \App\Http\Controllers\FactionsController::class,
    ]);
});

/* 
Route::middleware('admin')->group(function(){
    Route::resources([
        'users' => \App\Http\Controllers\UserController::class,
        'factions' => \App\Http\Controllers\FactionsController::class,
        'companies' => \App\Http\Controllers\CompaniesController::class,
        'skills' => \App\Http\Controllers\SkillsController::class,
        'skill-types' => \App\Http\Controllers\SkillTypesController::class,
        'classes' => \App\Http\Controllers\ClassesController::class,
        'class-types' => \App\Http\Controllers\ClassTypesController::class,
        'weapons' => \App\Http\Controllers\WeaponController::class,
        'weapon-types' => \App\Http\Controllers\WeaponTypeController::class,
    ]);
}); 
*/

require __DIR__.'/auth.php';
