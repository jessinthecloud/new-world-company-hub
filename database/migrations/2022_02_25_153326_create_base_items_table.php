<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBaseItemsTable extends Migration
{
    public function up()
    {
        Schema::create( 'base_items', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->string('name');
            // key from the json data
            $table->string('data_key')->unique();
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('item_class')->nullable();
            $table->string('bind_on_pickup')->nullable();
            $table->string('bind_on_equip')->nullable();
            $table->string('gear_score_override')->nullable();
            $table->tinyInteger('min_gear_score')->nullable();
            $table->tinyInteger('max_gear_score')->nullable();
            $table->tinyInteger('tier')->nullable();
            $table->string('item_stats_ref')->nullable();
            $table->boolean('can_have_perks')->nullable();
            $table->boolean('can_replace_gem')->nullable();
            $table->string('perk1')->nullable();
            $table->string('perk2')->nullable();
            $table->string('perk3')->nullable();
            $table->string('perk4')->nullable();
            $table->string('perk5')->nullable();
            $table->string('perk_bucket1')->nullable();
            $table->string('perk_bucket2')->nullable();
            $table->string('perk_bucket3')->nullable();
            $table->string('perk_bucket4')->nullable();
            $table->string('perk_bucket5')->nullable();
            $table->string('force_rarity')->nullable();
            $table->string('required_level')->nullable();
            $table->string('use_type_affix')->nullable();
            $table->string('use_material_affix')->nullable();
            $table->string('use_magic_affix')->nullable();
            $table->string('icon_capture_group')->nullable();
            $table->string('ui_item_class')->nullable();
            $table->string('consume_on_use')->nullable();
            $table->string('icon_path')->nullable();
            $table->string('hi_res_icon_path')->nullable();
            $table->string('max_stack_size')->nullable();
            $table->string('nonremovable')->nullable();
            $table->string('is_mission_item')->nullable();
            $table->string('is_unique_item')->nullable();
            $table->string('is_salvageable')->nullable();
            $table->string('salvage_resources')->nullable();
            $table->string('is_repairable')->nullable();
            $table->string('repair_recipe')->nullable();
            $table->string('crafting_recipe')->nullable();
            $table->string('repair_types')->nullable();
            $table->string('extra_bonus_item_chance')->nullable();
            $table->string('durability')->nullable();
            $table->string('durability_dmg_on_death')->nullable();
            $table->string('destroy_on_break')->nullable();
            $table->string('weight')->nullable();
            $table->string('mannequin_tag')->nullable();
            $table->string('warboard_gather_stat')->nullable();
            $table->string('warboard_deposit_stat')->nullable();
            $table->string('notes')->nullable();

            $table->timestamps();
        } );
    }

    public function down()
    {
        Schema::dropIfExists( 'base_items' );
    }
}