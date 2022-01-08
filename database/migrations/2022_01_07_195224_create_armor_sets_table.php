<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmorSetsTable extends Migration
{
    public function up()
    {
        Schema::create( 'armor_sets', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('slug')->unique();

            $table->timestamps();
        } );
        
        Schema::create( 'armor_armor_set', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('armor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('armor_set_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        } );
        
        Schema::create( 'armor_perk', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            
            $table->foreignId('perk_id')->constrained()->cascadeOnDelete();
            $table->foreignId('armor_id')->constrained()->cascadeOnDelete();
            $table->integer('amount');
            
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'armor_armor_set' );
        Schema::dropIfExists( 'armor_sets' );
        Schema::dropIfExists( 'armor_perk' );
    }
}