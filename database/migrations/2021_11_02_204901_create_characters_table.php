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
            $table->string('slug')->nullable()->unique();
            $table->smallInteger('level')->nullable();
            $table->foreignId('character_class_id')->constrained();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('rank_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'characters' );
    }
}