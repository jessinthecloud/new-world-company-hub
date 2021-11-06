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

require __DIR__.'/auth.php';
