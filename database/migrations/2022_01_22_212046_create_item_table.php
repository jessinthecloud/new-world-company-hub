<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    public function up()
    {
        Schema::create( 'items', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('itemable_type');
            // weapon or armor, etc
            $table->unsignedBigInteger('itemable_id');

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'items' );
    }
}