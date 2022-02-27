<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class PerkSeeder extends Seeder
{
    public function run()
    {
        $perks = DB::table('ItemPerks')->get();

        $upsert = [];
        foreach ( $perks as $perk_array ) {
            
            $perk_array = (array)$perk_array;
            
            $perk_name = !empty($perk_array['DisplayName']) 
                ? $perk_array['DisplayName'] 
                : $perk_array['PerkID'];
            $perk_type_id = DB::table('perk_types')
                ->where('json_key', $perk_array['PerkType'])
                ->first()?->id;
            $tier_id = DB::table('tiers')
                ->where('number', $perk_array['Tier'])
                ->first()?->id;
            $prefix_id = DB::table('prefixes')
                ->where('name', $perk_array['AppliedPrefix'])
                ->first()?->id;
            $suffix_id = DB::table('suffixes')
                ->where('name', $perk_array['AppliedSuffix'])
                ->first()?->id;

            $row = [
                'name'         => $perk_name,
                'slug'         => Str::slug($perk_array['PerkID']),
                'json_key'     => $perk_array['PerkID'],
                'perk_type_id' => $perk_type_id,
                'tier_id'      => $tier_id ?? null,
                'prefix_id'    => $prefix_id ?? null,
                'suffix_id'    => $suffix_id ?? null,
            ];

            // make sure corresponding column exists in table
            $perk_array = collect($perk_array)->filter(function ($value, $key) {
                return Schema::hasColumn('perks', Str::snake($key)) && $key != 'id';
            })->all();

            // format like column names 
            $keys = array_map(function ($key) {
                return Str::snake($key);
            }, array_keys($perk_array));

            $perk_array = array_combine($keys, array_values($perk_array));
//dd(array_merge($perk_array, $row));
            $upsert [] = array_merge($perk_array, $row);
//dd($upsert);
        } // end each perks
dump(end($upsert), reset($upsert));
        foreach(array_chunk($upsert, 2000) as $upsert_array){
            DB::table('perks')->upsert($upsert_array, ['json_key']);
        }
    }
}
