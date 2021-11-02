<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactionsTable extends Migration
{
    public function up()
    {
        Schema::create( 'factions', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string('name');
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'factions' );
    }
}