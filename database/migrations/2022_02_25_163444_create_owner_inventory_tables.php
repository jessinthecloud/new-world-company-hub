<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerInventoryTables extends Migration
{
    public function up()
    {
        Schema::create( 'company_inventory', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('company_id')->constrained();
            $table->foreignId('banker_id')->nullable()->constrained('characters');
            $table->foreignId('item_id')->constrained();

            $table->timestamps();
        } );
        
        Schema::create( 'character_inventory', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('character_id')->constrained();
            $table->foreignId('item_id')->constrained();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'company_inventory' );
        Schema::dropIfExists( 'character_inventory' );
    }
}