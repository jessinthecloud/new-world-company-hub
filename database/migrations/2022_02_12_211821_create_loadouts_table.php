<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoadoutsTable extends Migration
{
    public function up()
    {
        Schema::create( 'loadouts', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name')->nullable();
            $table->unsignedFloat('weight')->nullable();
            $table->unsignedInteger('gear_score')->nullable();
            // class via character
            $table->foreignId('character_id')->constrained();
            $table->foreignId('main_hand_id')->constrained('inventory_items');
            $table->foreignId('offhand_id')->constrained('inventory_items');
            $table->foreignId('head_id')->nullable()->constrained('inventory_items');
            $table->foreignId('chest_id')->nullable()->constrained('inventory_items');
            $table->foreignId('legs_id')->nullable()->constrained('inventory_items');
            $table->foreignId('feet_id')->nullable()->constrained('inventory_items');
            $table->foreignId('hands_id')->nullable()->constrained('inventory_items');
            $table->foreignId('neck_id')->nullable()->constrained('inventory_items');
            $table->foreignId('ring_id')->nullable()->constrained('inventory_items');
            $table->foreignId('earring_id')->nullable()->constrained('inventory_items');
            $table->foreignId('shield_id')->nullable()->constrained('inventory_items');

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'loadouts' );
    }
}