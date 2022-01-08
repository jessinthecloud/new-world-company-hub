<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuildBanksTable extends Migration
{
    public function up()
    {
        Schema::create( 'guild_banks', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->foreignId('company_id')->nullable()->constrained()->onDelete('SET NULL');
            // polymorphic: could be armor or weapon
            $table->foreignId('bankable_id');
            // class name of model
            $table->string('bankable_type');
            $table->integer('amount');

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'guild_banks' );
    }
}