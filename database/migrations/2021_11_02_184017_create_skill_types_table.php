<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillTypesTable extends Migration
{
    public function up()
    {
        Schema::create( 'skill_types', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('description');
            $table->smallInteger('order');

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'skill_types' );
    }
}