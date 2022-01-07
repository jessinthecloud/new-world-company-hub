<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerksTable extends Migration
{
    public function up()
    {
        Schema::create( 'perks', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->integer('json_id');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('perk_type'); // PHP enum
            $table->string('item_class')->nullable(); // PHP enum
            $table->string('cdn_asset_path')->nullable();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'perks' );
    }
}