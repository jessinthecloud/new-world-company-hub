<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('war_groups', function (Blueprint $table) {
            $table->id();

            $table->string('label');
            $table->smallInteger('order')->nullable();
            $table->foreignId('war_board_id')->constrained();

            $table->timestamps();
        });
        
        Schema::create('war_group_slots', function (Blueprint $table) {
            $table->id();

            $table->foreignId('war_group_id')->constrained();
            // Dex DPS, Healer, etc
            $table->string('description')->nullable();
            // open, filled, etc
            $table->unsignedTinyInteger('status')->nullable();
            $table->unsignedTinyInteger('order')->default(99);
            // class / character
            $table->string('slottable_type')->nullable();
            $table->unsignedBigInteger('slottable_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('war_group_slots');
        Schema::dropIfExists('war_groups');
    }
}