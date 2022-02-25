<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumableDataTable extends Migration
{
    public function up()
    {
        Schema::create('consumable_data', function (Blueprint $table) {
            $table->id();

            // base item this data belongs to
            $table->foreignId('base_item_id')->nullable()->constrained();

            $table->string('consumable_i_d')->nullable();
            $table->string('add_status_effects')->nullable();
            $table->string('status_effect_mod')->nullable();
            $table->string('duration_overrides')->nullable();
            $table->string('min_duration_modifier')->nullable();
            $table->string('max_duration_modifier')->nullable();
            $table->string('duration_scale_factor')->nullable();
            $table->string('min_potency_modifier')->nullable();
            $table->string('max_potency_modifier')->nullable();
            $table->string('potency_scale_factor')->nullable();
            $table->string('remove_status_effects')->nullable();
            $table->string('remove_status_effect_categories')->nullable();
            $table->string('display_status_effect')->nullable();
            $table->string('use_count')->nullable();
            $table->string('weapon_use_count')->nullable();
            $table->string('affliction_damage')->nullable();
            $table->string('base_damage_modifier')->nullable();
            $table->string('base_damage_type')->nullable();
            $table->string('damage_type')->nullable();
            $table->string('damage')->nullable();
            $table->string('d_m_g_vitals_category')->nullable();
            $table->string('on_use_affliction')->nullable();
            $table->string('stat_multipliers')->nullable();
            $table->string('required_item_class')->nullable();
            $table->string('mannequin_tag')->nullable();
            $table->string('cooldown_duration')->nullable();
            $table->string('cooldown_id')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('consumable_data');
    }
}