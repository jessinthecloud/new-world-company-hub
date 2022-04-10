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

// VERSION 1 ---------------------------------------------------
// /api/v1/
Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::get('/base-weapons/{baseWeapon}', function (BaseWeapon $baseWeapon) {
        return new \App\Http\Resources\BaseWeaponResource($baseWeapon->load('perks'));
    })
        ->name('base-weapons.show');
        
    Route::get('/base-weapons', function (Request $request) {
        return new \App\Http\Resources\BaseWeaponResource(BaseWeapon::all());
    })
        ->name('base-weapons.index');
 
    
});

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/
