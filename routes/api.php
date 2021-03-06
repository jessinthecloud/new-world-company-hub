<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Models\Items\BaseWeapon;
use App\Models\Items\Perk;

// VERSION 1 ---------------------------------------------------
// /api/v1/
Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('/base-weapons/{baseWeapon}', function (BaseWeapon $baseWeapon) {
        return new \App\Http\Resources\BaseWeaponResource($baseWeapon);
    })
        ->name('base-weapons.show');
        
    Route::get('/base-weapons/{baseWeapon}/perks', function (BaseWeapon $baseWeapon) {
        $perks = Perk::whereRelation('baseWeapons', 'base_weapons.id', $baseWeapon->id)->get();
        // todo: parse $request query string for constraints
        return \App\Http\Resources\PerkResource::collection($perks);
    })
        ->name('base-weapons.show.perks');
        
    Route::get('/base-weapons', function () {
        $weapons = !empty(request()->query('page')) ? BaseWeapon::paginate() : BaseWeapon::all();
        return \App\Http\Resources\BaseWeaponResource::collection($weapons);
    })
        ->name('base-weapons.index');
});

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
