<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseWeaponsTable extends Migration
{
    public function up()
    {
        Schema::create( 'base_weapons', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            $table->string('json_id');
            $table->string('slug')->unique();
            $table->string('equip_type')->nullable(); // PHP enum
            $table->string('type')->nullable(); // PHP enum
//            $table->string('long_name')->nullable();
            $table->text('description')->nullable();
            $table->string('tier')->nullable(); // PHP enum
            $table->string('rarity')->nullable(); // PHP enum
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

            $table->string('base_damage')->nullable();
            $table->string('stagger_damage')->nullable();
            $table->string('crit_chance')->nullable();
            $table->string('crit_multiplier')->nullable();


            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'base_weapons' );
    }
}