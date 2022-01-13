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

            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->string('type')->nullable(); // PHP enum
            $table->string('description')->nullable();
            $table->string('tier')->nullable(); // PHP enum
            $table->string('rarity')->nullable(); // PHP enum
            $table->integer('gear_score')->nullable();
            $table->string('required_level')->nullable();
            $table->string('cdn_asset_path')->nullable();
            
            $table->foreignId('base_id')->nullable()->constrained('base_weapons');
            // character or company
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('character_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        } );
        
        Schema::create( 'perk_weapon', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            
            $table->foreignId('perk_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weapon_id')->constrained()->cascadeOnDelete();
            $table->integer('amount')->nullable();
            
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'perk_weapon' );
        Schema::dropIfExists( 'weapons' );
    }
}