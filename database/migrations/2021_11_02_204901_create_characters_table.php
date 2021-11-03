<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    public function up()
    {
        Schema::create( 'characters', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->smallInteger('level');
            $table->foreignId('character_class_id')->constrained();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('rank_id')->constrained();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'characters' );
    }
}