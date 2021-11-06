<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscordDataTable extends Migration
{
    public function up()
    {
        Schema::create( 'discord_data', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('name');
            $table->string('nickname');
            $table->string('email')->unique();
            $table->string('avatar')->nullable();
            $table->string('token')->nullable();
            $table->string('refresh_token')->nullable();
            $table->string('expires_in')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists( 'discord_data' );
    }
}