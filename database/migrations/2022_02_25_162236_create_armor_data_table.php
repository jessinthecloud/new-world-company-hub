<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArmorDataTable extends Migration
{
    public function up()
    {
        /*Schema::create('armor_data', function (Blueprint $table) {
            $table->id();
            
            // base item this data belongs to
            $table->foreignId('base_item_id')->nullable()->constrained();
            
            $table->string('weapon_i_d')->nullable();
            $table->string('grit')->nullable();
            $table->string('physical_armor_set_scale_factor')->nullable();
            $table->string('elemental_armor_set_scale_factor')->nullable();
            $table->string('armor_rating_scale_factor')->nullable();
            $table->string('weight_override')->nullable();
            $table->string('encumbrance')->nullable();
            $table->string('encumbrance_per_g_s')->nullable();
            $table->string('weight_class')->nullable();
            $table->string('equip_load')->nullable();
            $table->string('max_health_mod')->nullable();
            $table->string('health_rate')->nullable();
            $table->string('max_stamina_mod')->nullable();
            $table->string('stamina_rate')->nullable();
            $table->string('max_mana_mod')->nullable();
            $table->string('mana_rate')->nullable();
            $table->string('max_food_mod')->nullable();
            $table->string('food_burn')->nullable();
            $table->string('max_drink_mod')->nullable();
            $table->string('drink_burn')->nullable();
            $table->string('b_o_n_logging')->nullable();
            $table->string('b_o_n_mining')->nullable();
            $table->string('b_o_n_skinning')->nullable();
            $table->string('b_o_n_harvesting')->nullable();
            $table->string('e_f_f_logging')->nullable();
            $table->string('e_f_f_mining')->nullable();
            $table->string('e_f_f_skinning')->nullable();
            $table->string('e_f_f_harvesting')->nullable();
            $table->string('r_o_l_logging')->nullable();
            $table->string('r_o_l_mining')->nullable();
            $table->string('r_o_l_skinning')->nullable();
            $table->string('r_o_l_harvesting')->nullable();
            $table->string('r_o_l_alchemy')->nullable();
            $table->string('r_o_l_blacksmithing')->nullable();
            $table->string('r_o_l_engineering')->nullable();
            $table->string('r_o_l_outfitting')->nullable();
            $table->string('r_o_l_provisioning')->nullable();
            $table->string('r_o_l_camping')->nullable();
            $table->string('d_e_f_standard')->nullable();
            $table->string('d_e_f_siege')->nullable();
            $table->string('d_e_f_strike')->nullable();
            $table->string('d_e_f_slash')->nullable();
            $table->string('d_e_f_thrust')->nullable();
            $table->string('d_e_f_magic')->nullable();
            $table->string('d_e_f_fire')->nullable();
            $table->string('d_e_f_lightning')->nullable();
            $table->string('d_e_f_corruption')->nullable();
            $table->string('a_b_s_standard')->nullable();
            $table->string('a_b_s_siege')->nullable();
            $table->string('a_b_s_strike')->nullable();
            $table->string('a_b_s_slash')->nullable();
            $table->string('a_b_s_thrust')->nullable();
            $table->string('a_b_s_magic')->nullable();
            $table->string('a_b_s_fire')->nullable();
            $table->string('a_b_s_lightning')->nullable();
            $table->string('a_b_s_corruption')->nullable();
            $table->string('r_e_s_poison')->nullable();
            $table->string('r_e_s_disease')->nullable();
            $table->string('r_e_s_bleed')->nullable();
            $table->string('r_e_s_frostbite')->nullable();
            $table->string('r_e_s_curse')->nullable();
            $table->string('b_l_a_standard')->nullable();
            $table->string('b_l_a_siege')->nullable();
            $table->string('b_l_a_strike')->nullable();
            $table->string('b_l_a_slash')->nullable();
            $table->string('b_l_a_thrust')->nullable();
            $table->string('b_l_a_magic')->nullable();
            $table->string('b_l_a_fire')->nullable();
            $table->string('b_l_a_lightning')->nullable();
            $table->string('b_l_a_corruption')->nullable();
            $table->string('a_b_a_poison')->nullable();
            $table->string('a_b_a_disease')->nullable();
            $table->string('a_b_a_bleed')->nullable();
            $table->string('a_b_a_frostbite')->nullable();
            $table->string('a_b_a_curse')->nullable();
            $table->string('d_m_g_standard')->nullable();
            $table->string('d_m_g_siege')->nullable();
            $table->string('d_m_g_strike')->nullable();
            $table->string('d_m_g_slash')->nullable();
            $table->string('d_m_g_thrust')->nullable();
            $table->string('d_m_g_magic')->nullable();
            $table->string('d_m_g_fire')->nullable();
            $table->string('d_m_g_lightning')->nullable();
            $table->string('d_m_g_corruption')->nullable();
            $table->string('d_m_g_vitals_category')->nullable();
            $table->string('a_f_a_poison')->nullable();
            $table->string('a_f_a_disease')->nullable();
            $table->string('a_f_a_bleed')->nullable();
            $table->string('a_f_a_frostbite')->nullable();
            $table->string('a_f_a_curse')->nullable();

            $table->timestamps();
        });*/
    }

    public function down()
    {
        Schema::dropIfExists('armor_data');
    }
}