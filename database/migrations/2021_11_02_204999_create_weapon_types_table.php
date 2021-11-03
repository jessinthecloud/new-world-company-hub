<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeaponTypesTable extends Migration
{
    public function up()
    {
        Schema::create( 'weapon_types', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('description');
            // related mastery
            $table->foreignId('skill_id')->constrained();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'weapon_types' );
    }
}