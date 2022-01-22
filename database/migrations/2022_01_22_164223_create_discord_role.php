<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscordRole extends Migration
{
    public function up()
    {
        Schema::create( 'discord_roles', function ( Blueprint $table ) {
            $table->bigInteger( 'id' );
            $table->string( 'color' )->nullable();
            $table->string( 'icon' )->nullable();
            $table->bigInteger( 'permissions' );
            $table->foreignId( 'company_id' )->nullable()->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId( 'role_id' )->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'discord_roles' );
    }
}