<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmorsTable extends Migration
{
    public function up()
    {
        Schema::create( 'armors', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name')->nullable();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('type')->nullable(); // PHP enum
            $table->string('tier')->nullable(); // PHP enum
            $table->string('rarity')->nullable(); // PHP enum
            $table->string('weight_class')->nullable(); // PHP enum
            $table->integer('gear_score')->nullable();
            $table->string('required_level')->nullable();
            $table->string('cdn_asset_path')->nullable();
            
            $table->foreignId('base_id')->nullable()->constrained('base_armors');
            // character or company
            $table->foreignId('company_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('character_id')->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'armors' );
    }
}