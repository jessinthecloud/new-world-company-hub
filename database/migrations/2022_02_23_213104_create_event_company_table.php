<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventCompanyTable extends Migration
{
    public function up()
    {
        Schema::create('event_company', function (Blueprint $table) {
            $table->id();

            $table->foreignId('event_id')->constrained();
            $table->foreignId('company_id')->constrained();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('event_company');
    }
}