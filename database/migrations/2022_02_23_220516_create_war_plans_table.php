<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarPlansTable extends Migration
{
    public function up()
    {
        Schema::create('war_plans', function (Blueprint $table) {
            $table->id();

            $table->string('title')->nullable();
            $table->foreignId('company_id')->constrained();
            $table->foreignId('event_id')->nullable()->constrained();
            $table->text('text');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('war_plans');
    }
}