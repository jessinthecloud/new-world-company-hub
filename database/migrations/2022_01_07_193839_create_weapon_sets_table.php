<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeaponSetsTable extends Migration
{
    public function up()
    {
        Schema::create( 'weapon_sets', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('slug')->unique();

            $table->timestamps();
        } );
        
        Schema::create( 'weapon_weapon_set', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('weapon_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weapon_set_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        } );
        
        Schema::create( 'base_weapon_perk', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            
            $table->foreignId('perk_id')->constrained()->cascadeOnDelete();
            $table->foreignId('base_weapon_id')->constrained()->cascadeOnDelete();
            $table->float('chance')->nullable();
            
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'weapon_weapon_set' );
        Schema::dropIfExists( 'weapon_sets' );
        Schema::dropIfExists( 'base_weapon_perk' );
    }
}