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
            $table->foreignId('company_id')->nullable()->constrained();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rank_id')->nullable()->constrained()->nullOnDelete();
//            $table->foreignId('mainhand_id')->nullable()->constrained('weapons')->nullOnDelete();
            $table->string('mainhand')->nullable();
//            $table->foreignId('offhand_id')->nullable()->constrained('weapons')->nullOnDelete();
            $table->string('offhand')->nullable();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'characters' );
    }
}