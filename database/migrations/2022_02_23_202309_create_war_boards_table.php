<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarBoardsTable extends Migration
{
    public function up()
    {
        Schema::create('war_boards', function (Blueprint $table) {
            $table->id();
            
            $table->string('description')->nullable();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('event_id')->nullable()->constrained();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('war_boards');
    }
}