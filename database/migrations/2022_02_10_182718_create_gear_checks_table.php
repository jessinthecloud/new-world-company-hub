<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGearChecksTable extends Migration
{
    public function up()
    {
        Schema::create( 'gear_checks', function ( Blueprint $table ) {
            $table->id();
            $table->foreignId('approver_id')->constrained('characters');
            $table->foreignId('loadout_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'gear_checks' );
    }
}