<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeaponDataTable extends Migration
{
    public function up()
    {
        Schema::create('weapon_data', function (Blueprint $table) {
            $table->id();
            
            // base item this data belongs to
            $table->foreignId('base_item_id')->nullable()->constrained();

            $table->string('weapon_i_d')->nullable();
            $table->string('base_weapon_i_d')->nullable();
            $table->string('d_e_v')->nullable();
            $table->string('primary_use')->nullable();
            $table->string('icon_path')->nullable();
            $table->string('max_stack_size')->nullable();
            $table->string('equip_type')->nullable();
            $table->string('damage_stat_multiplier')->nullable();
            $table->string('weapon_mastery_category_id')->nullable();
            $table->string('tier_number')->nullable();
            $table->string('base_damage')->nullable();
            $table->string('crit_chance')->nullable();
            $table->string('crit_damage_multiplier')->nullable();
            $table->string('base_stagger_damage')->nullable();
            $table->string('crit_stagger_damage_multiplier')->nullable();
            $table->string('reticle_name')->nullable();
            $table->string('reticle_target_name')->nullable();
            $table->string('reticle_ray_cast_distance')->nullable();
            $table->string('ammo_type')->nullable();
            $table->string('max_loaded_ammo')->nullable();
            $table->string('ammo_mesh')->nullable();
            $table->string('mannequin_tag')->nullable();
            $table->string('off_hand_mannequin_tag')->nullable();
            $table->string('mesh_override')->nullable();
            $table->string('skin_override1')->nullable();
            $table->string('material_override1')->nullable();
            $table->string('skin_override2')->nullable();
            $table->string('material_override2')->nullable();
            $table->string('skin_override3')->nullable();
            $table->string('material_override3')->nullable();
            $table->string('skin_override4')->nullable();
            $table->string('material_override4')->nullable();
            $table->string('fire_joint')->nullable();
            $table->string('damage_table_row')->nullable();
            $table->string('tooltip_primary_attack_data')->nullable();
            $table->string('tooltip_alternate_attack_data')->nullable();
            $table->string('anim_db_path')->nullable();
            $table->string('gathering_types')->nullable();
            $table->string('gathering_multiplier')->nullable();
            $table->string('gathering_efficiency')->nullable();
            $table->string('min_gather_e_f_f')->nullable();
            $table->string('max_gather_e_f_f')->nullable();
            $table->string('audio_pickup')->nullable();
            $table->string('audio_place')->nullable();
            $table->string('primary')->nullable();
            $table->string('equipment_categories')->nullable();
            $table->string('required_strength')->nullable();
            $table->string('required_dexterity')->nullable();
            $table->string('required_intelligence')->nullable();
            $table->string('required_focus')->nullable();
            $table->string('scaling_strength')->nullable();
            $table->string('scaling_dexterity')->nullable();
            $table->string('scaling_intelligence')->nullable();
            $table->string('scaling_focus')->nullable();
            $table->string('resistances')->nullable();
            $table->string('weaknesses')->nullable();
            $table->string('stat_bonuses')->nullable();
            $table->string('stat_multipliers')->nullable();
            $table->string('equipment_category_multiplier')->nullable();
            $table->string('attack_game_event_i_d')->nullable();
            $table->string('physical_armor_set_scale_factor')->nullable();
            $table->string('elemental_armor_set_scale_factor')->nullable();
            $table->string('armor_rating_scale_factor')->nullable();
            $table->string('weight_override')->nullable();
            $table->string('block_stamina_damage')->nullable();
            $table->string('block_stability')->nullable();
            $table->string('deflection_rating')->nullable();
            $table->string('disable_perks_on_sheathe')->nullable();
            $table->string('b_l_a_standard')->nullable();
            $table->string('b_l_a_siege')->nullable();
            $table->string('b_l_a_strike')->nullable();
            $table->string('b_l_a_slash')->nullable();
            $table->string('b_l_a_thrust')->nullable();
            $table->string('b_l_a_arcane')->nullable();
            $table->string('b_l_a_fire')->nullable();
            $table->string('b_l_a_ice')->nullable();
            $table->string('b_l_a_nature')->nullable();
            $table->string('b_l_a_lightning')->nullable();
            $table->string('b_l_a_corruption')->nullable();
            $table->string('a_b_a_poison')->nullable();
            $table->string('a_b_a_disease')->nullable();
            $table->string('a_b_a_bleed')->nullable();
            $table->string('a_b_a_frostbite')->nullable();
            $table->string('a_b_a_curse')->nullable();
            $table->string('ranged_attack_profile')->nullable();
            $table->string('attached_spell_data')->nullable();
            $table->string('appearance')->nullable();
            $table->string('female_appearance')->nullable();
            $table->string('can_block_ranged')->nullable();
            $table->string('mana_cost_id')->nullable();
            $table->string('weapon_effect_id')->nullable();
            $table->string('base_accuracy')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('weapon_data');
    }
}