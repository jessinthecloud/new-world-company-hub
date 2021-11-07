<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadoutsTable extends Migration
{
    public function up()
    {
        Schema::create( 'loadouts', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name')->nullable();
            $table->unsignedFloat('weight');
            // class via character
            $table->foreignId('character_id')->constrained();
            $table->foreignId('main_hand_id')->constrained('weapons');
            $table->foreignId('offhand_id')->constrained('weapons');

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'loadouts' );
    }
}