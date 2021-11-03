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

            $table->string('name');
            $table->string('description');
            $table->foreignId('weapon_type_id')->constrained();


            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'weapons' );
    }
}