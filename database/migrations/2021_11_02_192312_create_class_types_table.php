<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassTypesTable extends Migration
{
    public function up()
    {
        Schema::create( 'character_class_types', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('description')->nullable();
            $table->smallInteger('order')->default(9999);

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'class_types' );
    }
}