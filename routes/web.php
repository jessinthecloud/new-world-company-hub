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
//    $characters = \App\Models\Character::with(['loadouts', 'class', 'class.type', 'skills', 'user', 'rank'])->get();
    
    $ranks = \App\Models\Rank::distinct()->get()->mapWithKeys(function($rank){
        return [$rank->name => $rank->id];
    })->all();

    $skills = \App\Models\Skill::distinct()->get()->mapWithKeys(function($skill, $key){
        return [$skill->name => $skill->id];
    })->all();
    
//dd( $ranks );    
    return view('dashboard', ['ranks'=>$ranks, 'form_action'=>route('dashboard')]);
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function(){
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
