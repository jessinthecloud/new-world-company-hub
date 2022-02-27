<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewPerksTable extends Migration
{
    public function up()
    {
        Schema::create('perk_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->unique(); // gem, attribute, perk
            $table->timestamps();
        });

        Schema::create('prefixes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->unique(); // Empowered, Imbued...
            $table->timestamps();
        });

        Schema::create('suffixes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50)->unique(); // of the Soldier, of the Scholar...
            $table->timestamps();
        });

        Schema::create('perks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            // key from the json data
            $table->string('json_key')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('perk_type_id')->constrained();
            $table->foreignId('affix_id')->nullable()->constrained();
            $table->foreignId('prefix_id')->nullable()->constrained();
            $table->foreignId('suffix_id')->nullable()->constrained();
            
        // -- raw data
            $table->string('group_name')->nullable();
            $table->string('condition_event')->nullable();
            $table->string('equip_ability')->nullable();
            $table->string('item_class')->nullable();
            $table->string('exclude_item_class')->nullable();
            $table->string('exclusive_labels')->nullable();
            $table->tinyInteger('channel')->nullable();
            $table->float('scaling_per_gear_score')->nullable();
            $table->string('tier')->nullable();
            $table->string('applied_prefix', 100)->nullable();
            $table->string('applied_suffix', 100)->nullable();
            $table->string('name_priority', 100)->nullable();
            $table->string('icon_path')->nullable();
            $table->string('icon')->nullable();
            $table->string('affix')->nullable();
            $table->string('day_phases')->nullable();

            $table->timestamps();
        });
        
        // PIVOT TABLES
        Schema::create('base_item_perk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('perk_id')->constrained();
            $table->foreignId('base_item_id')->constrained();
            $table->timestamps();
        });
        
        Schema::create('item_perk', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('perk_id')->constrained();
            $table->foreignId('item_id')->constrained();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('base_item_perk');
        Schema::dropIfExists('item_perk');
        Schema::dropIfExists('perks');
        Schema::dropIfExists('prefixes');
        Schema::dropIfExists('suffixes');
        Schema::dropIfExists('perk_types');
    }
}