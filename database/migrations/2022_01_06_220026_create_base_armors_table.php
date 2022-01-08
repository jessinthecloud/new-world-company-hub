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
            $table->string('long_name')->nullable();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('armor_type'); // PHP enum
            $table->string('tier')->nullable(); // PHP enum
            $table->string('rarity')->nullable(); // PHP enum
            $table->string('weight_class')->nullable(); // PHP enum
            $table->string('source')->nullable(); // PHP enum
            $table->string('required_level')->nullable();
            $table->string('gear_score_override')->nullable();
            $table->string('min_gear_score')->nullable(); 
            $table->string('max_gear_score')->nullable();
            $table->string('cdn_asset_path')->nullable();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'base_armors' );
    }
}