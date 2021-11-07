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
    // find char selected in drop down
    Route::post('/characters/find', [\App\Http\Controllers\CharactersController::class, 'find'])->name('characters.find');
    
    Route::get('/characters/edit', [\App\Http\Controllers\CharactersController::class, 'edit'])->name('characters.edit');
    Route::get('/characters/destroy', [\App\Http\Controllers\CharactersController::class, 'destroy'])->name('characters.destroy');
    
    Route::resources([
        'characters' => \App\Http\Controllers\CharactersController::class,
        'loadouts' => \App\Http\Controllers\LoadoutsController::class,
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
