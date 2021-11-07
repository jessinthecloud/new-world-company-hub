<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassesTable extends Migration
{
    public function up()
    {
        Schema::create( 'character_classes', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('description')->nullable();
            $table->smallInteger('order')->default(9999);
            $table->foreignId('character_class_type_id')->constrained();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'classes' );
    }
}