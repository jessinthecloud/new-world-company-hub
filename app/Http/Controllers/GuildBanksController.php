<?php

namespace App\Http\Controllers;

use App\Enums\ArmorType;
use App\Enums\PerkType;
use App\Enums\Rarity;
use App\Enums\Tier;
use App\Enums\WeaponType;
use App\Enums\WeightClass;
use App\Models\Armor;
use App\Models\BaseArmor;
use App\Models\BaseWeapon;
use App\Models\Company;
use App\Models\GuildBank;
use App\Models\Perk;
use App\Models\Weapon;
use Illuminate\Http\Request;

class GuildBanksController extends Controller
{
    public function show( GuildBank $guildBank )
    {
        // Guild Bank Livewire Table?
    }

    public function edit( GuildBank $guildBank )
    {
        // add items to bank
        // or edit company attached (super-admin)
        
        $companies = Company::orderBy('name')->distinct()->get()->mapWithKeys(function($company){
            return [$company->slug => $company->name];
        })->all();

        $company_options = '';
        foreach($companies as $value => $text) {
            $company_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        $armor = BaseArmor::orderBy('name')->distinct()->get()->mapWithKeys(function($armor){
            return [$armor->slug => $armor->long_name ?? $armor->name];
        })->all();

        $armor_options = '<option value=""></option>';
        foreach($armor as $value => $text) {
            $armor_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        $weapons = BaseWeapon::orderBy('name')->distinct()->get()->mapWithKeys(function($weapon){
            return [$weapon->slug => $weapon->long_name ?? $weapon->name];
        })->all();

        $weapon_options = '<option value=""></option>';
        foreach($weapons as $value => $text) {
            $weapon_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        $perks = Perk::orderBy('name')->distinct()->get()->mapWithKeys(function($perk){
            return [$perk->slug => $perk->name];
        })->all();

        $perk_options = '<option value="">None</option>';
        foreach($perks as $value => $text) {
            $perk_options .= '<option value="'.$value.'">'.$text.'</option>';
        }

        $weapon_type_options = '';
        foreach(WeaponType::cases() as $type) {
            $weapon_type_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        $armor_type_options = '';
        foreach(ArmorType::cases() as $type) {
            $armor_type_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        $perk_type_options = '<option value=""></option>';
        foreach(PerkType::cases() as $type) {
            $perk_type_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        $rarity_options = '';
        foreach(Rarity::cases() as $type) {
            $rarity_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        $tier_options = '<option value=""></option>';
        foreach(Tier::cases() as $type) {
            $tier_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        $weight_class_options = '<option value="">None</option>';
        foreach(WeightClass::cases() as $type) {
            $weight_class_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }

        return view(
            'dashboard.guild-bank.create-edit',
            [
                'armor_options' => $armor_options,
                'weapon_options' => $weapon_options,
                'armor_type_options' => $armor_type_options,
                'weapon_type_options' => $weapon_type_options,
                'perk_options' => $perk_options,
                'perk_type_options' => $perk_type_options,
                'rarity_options' => $rarity_options,
                'tier_options' => $tier_options,
                'weight_class_options' => $weight_class_options,
                'company_options' => $company_options,
                'method' => 'PUT',
                'form_action' => route('guild-banks.update', ['guild_bank'=>$guildBank]),
                'button_text' => 'Update',
            ]
        );
    }

    public function update( Request $request, GuildBank $guildBank )
    {
        //
    }
    
    public function choose()
    {
        $guildBanks = GuildBank::get()->sortBy('company.name')->mapWithKeys(function($guildBank){
            return [$guildBank->id => $guildBank->company->name.' Guild Bank'];
        })->all();
        $form_action = route('guild-banks.find');

        return view(
            'dashboard.guild-bank.choose',
            compact('guildBanks', 'form_action')
        );
    }

    public function find(Request $request)
    {
//    ddd($request);
        return redirect(
            route('guild-banks.'.$request->action, [
                'guild_bank'=>$request->guildBank
            ])
        );
    }

    public function index()
    {
        // (super-admin)
    }

    public function create()
    {
        // (super-admin)
    }

    public function store( Request $request )
    {
        // (super-admin)
    }

    public function destroy( GuildBank $guildBank )
    {
        // governor / (super-admin)
    }
}