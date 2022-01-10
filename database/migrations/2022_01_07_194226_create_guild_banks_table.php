<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuildBanksTable extends Migration
{
    public function up()
    {
        Schema::create( 'guild_banks', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('company_id')->constrained();

            $table->timestamps();
        } );
        
        Schema::create( 'weapon_inventory', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('guild_bank_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->foreignId('weapon_id')->constrained()->cascadeOnDelete();
            $table->integer('amount')->nullable();

            $table->timestamps();
        } );
        
        Schema::create( 'armor_inventory', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('guild_bank_id')->nullable()->constrained()->onDelete('SET NULL');
            $table->foreignId('armor_id')->constrained()->cascadeOnDelete();
            $table->integer('amount')->nullable();

            $table->timestamps();
        } );
        
    }

    public function down()
    {
        Schema::dropIfExists( 'weapon_inventory' );
        Schema::dropIfExists( 'armor_inventory' );
        Schema::dropIfExists( 'guild_banks' );
    }
}