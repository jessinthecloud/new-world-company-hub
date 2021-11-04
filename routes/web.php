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
    $characters = \App\Models\Character::with(['loadouts', 'class', 'class.type', 'skills', 'user', 'rank'])->get();
    
    $ranks = $characters->pluck('rank')->unique()->map(function($rank){
        return ['value'=>$rank->id, 'text' => $rank->name];
    })->all();
    
//dd( $ranks );    
    return view('dashboard', compact('characters', 'ranks'));
    
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
