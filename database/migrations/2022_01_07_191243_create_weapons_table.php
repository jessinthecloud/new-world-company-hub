<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeaponsTable extends Migration
{
    public function up()
    {
        Schema::create( 'weapons', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('weapon_type'); // PHP enum
            $table->string('description')->nullable();
            $table->string('tier'); // PHP enum
            $table->string('rarity'); // PHP enum
            $table->integer('gear_score')->nullable();
            $table->string('required_level')->nullable();
            $table->string('cdn_asset_path')->nullable();
            
            $table->foreignId('base_weapon_id')->nullable()->constrained();

            $table->timestamps();
        } );
        
        Schema::create( 'perk_weapon', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            
            $table->foreignId('perk_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weapon_id')->constrained()->cascadeOnDelete();
            $table->integer('amount');
            
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'perk_weapon' );
        Schema::dropIfExists( 'weapons' );
    }
}