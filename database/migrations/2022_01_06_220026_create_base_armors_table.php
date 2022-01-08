<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseArmorsTable extends Migration
{
    public function up()
    {
        Schema::create( 'base_armors', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('json_id');
//            $table->string('long_name')->nullable();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('type'); // PHP enum
            $table->string('tier')->nullable(); // PHP enum
            $table->string('rarity')->nullable(); // PHP enum
            $table->string('weight_class')->nullable(); // PHP enum
            $table->string('source')->nullable(); // PHP enum
            $table->string('required_level')->nullable();
            $table->string('gear_score')->nullable();
            $table->string('min_gear_score')->nullable(); 
            $table->string('max_gear_score')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->boolean('named')->nullable();
            $table->tinyInteger('num_perk_slots')->nullable();
            $table->float('weight')->nullable();
            $table->integer('maxStack')->nullable();
            $table->string('bindOnPickup')->nullable();
            $table->string('bindOnEquip')->nullable();
            $table->integer('durability')->nullable();
            $table->string('flagCanBeBought')->nullable();


            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'base_armors' );
    }
}