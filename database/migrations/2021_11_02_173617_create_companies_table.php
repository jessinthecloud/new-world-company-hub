<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    public function up()
    {
        /*
         * alter table companies
    add discord_guild_id BIGINT unsigned null after slug;

create unique index companies_discord_guild_id_uindex
    on companies (discord_guild_id);
         */
        Schema::create( 'companies', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('discord_guild_id')->unique();
            $table->foreignId('faction_id')->constrained();
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'companies' );
    }
}