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
            // weapon or armor
            $table->unsignedBigInteger('item_id')->nullable();
            // weapon or armor model
            $table->string('item_type')->nullable();

            $table->timestamps();
        } );
        
        
    }

    public function down()
    {
        Schema::dropIfExists( 'guild_banks' );
    }
}