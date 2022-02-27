<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiersTable extends Migration
{
    public function up()
    {
        Schema::create('tiers', function (Blueprint $table) {
            $table->id();

            $table->string('name'); // Tier 1
            $table->string('number'); // 1
            $table->string('code')->nullable(); // T1

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tiers');
    }
}