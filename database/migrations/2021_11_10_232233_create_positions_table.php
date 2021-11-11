<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionsTable extends Migration
{
    public function up()
    {
        Schema::create( 'positions', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('class_type_id')->constrained('character_class_types');
            $table->foreignId('roster_id')->constrained();
            $table->foreignId('character_id')->constrained();


            $table->timestamps();
        } );

        Schema::create( 'position_roster', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('position_id')->constrained();
            $table->foreignId('roster_id')->constrained();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'positions' );
    }
}