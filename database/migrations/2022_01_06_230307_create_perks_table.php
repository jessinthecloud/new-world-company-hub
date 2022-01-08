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
            $table->string('json_id')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('perk_type'); // PHP enum
//            $table->string('item_class')->nullable(); // PHP enum
            $table->string('tier')->nullable();
            $table->string('rarity')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();

            $table->string('ScalingPerGearScore')->nullable();
            $table->string('min_gear_score')->nullable();
            $table->string('max_gear_score')->nullable();
            $table->string('condition')->nullable();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'perks' );
    }
}