<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterSkillsTable extends Migration
{
    public function up()
    {
        Schema::create( 'character_skill', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('character_id')->constrained()->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            $table->smallInteger('level');

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'character_skill' );
    }
}