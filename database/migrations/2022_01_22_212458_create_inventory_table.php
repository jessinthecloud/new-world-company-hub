<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryTable extends Migration
{
    public function up()
    {
        Schema::create( 'inventory_items', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            // character or company
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type');
            $table->foreignId('item_id');

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'inventory' );
    }
}