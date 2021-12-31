<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        Schema::create( 'companies', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('faction_id')->constrained();
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'companies' );
    }
}