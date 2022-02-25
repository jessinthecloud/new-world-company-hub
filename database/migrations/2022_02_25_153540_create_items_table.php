<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    public function up()
    {
        Schema::create( 'item_types', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('data_key')->unique();
            $table->timestamps();
        } );
        
        Schema::create( 'item_subtypes', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('data_key')->unique();
            $table->foreignId('item_type_id')->nullable()->constrained();
            $table->timestamps();
        } );
        
        Schema::create( 'items', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('gear_score')->nullable();
            
        // -- FOREIGN KEYS
            // weapon, armor, consumable, etc
            $table->foreignId('item_type_id')->nullable()->constrained();
            // base item data
            $table->foreignId('base_item_id')->nullable()->constrained();
            
            $table->timestamps();
        } );
        
        Schema::create( 'equippable_item_data', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('data_key')->unique();
            $table->foreignId('item_type_id')->nullable()->constrained();
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'items' );
    }
}