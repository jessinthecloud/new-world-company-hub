<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    public function up()
    {
        Schema::create( 'attributes', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('attribute_type'); // php enum


            $table->timestamps();
        } );
        
        /*Schema::create( 'attribute_types', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('slug')->unique();

            $table->timestamps();
        } );*/
        
        /*Schema::create( 'attribute_attribute_type', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
            $table->integer('amount');
            $table->string('attribute_type'); // php enum
            
            $table->timestamps();
        } );*/
        
        Schema::create( 'attribute_armor', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
            $table->foreignId('armor_id')->constrained()->cascadeOnDelete();
            $table->integer('amount');
            
            $table->timestamps();
        } );
        
        Schema::create( 'attribute_weapon', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('attribute_id')->constrained()->cascadeOnDelete();
            $table->foreignId('weapon_id')->constrained()->cascadeOnDelete();
            $table->integer('amount');
            
            $table->timestamps();
        } );
    }

    public function down()
    {
//        Schema::dropIfExists( 'attribute_attribute_type' );
        Schema::dropIfExists( 'attribute_armor' );
        Schema::dropIfExists( 'attribute_weapon' );
        Schema::dropIfExists( 'attributes' );
//        Schema::dropIfExists( 'attribute_types' );
    }
}