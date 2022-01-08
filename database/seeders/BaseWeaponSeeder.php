<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class BaseWeaponSeeder extends Seeder
{
    public function run()
    {
        $dir = __DIR__ . '/../../storage/app/json/weapons';
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS )
        );
        foreach ( $files as $file ) {
            $weapons = json_decode( file_get_contents( $file->getPathname() ) );
//dd($data);
           
            $insert = [];
            foreach ( $weapons as $weapon ) {
                // create unique slug
                $slug = $weapon->name . ( !empty( $weapon->rarity ) ? ' ' . $weapon->rarity : '' ) . ( !empty( $weapon->tier ) ? ' t' . $weapon->tier : '' );
                $slug = Str::slug( $slug );
               
                $type = $weapon->itemClass[2] ?? null;
                $type = (isset($type) && $type == '2HHammer') ? 'WarHammer' : $type; 
                $type = (isset($type) && $type == '2HAxe') ? 'GreatAxe' : $type; 

                $insert [] = [
                    'name'                => $weapon->name,
                    'json_id'             => $weapon->id,
//                    'long_name'           => $weapon->name_with_affixes,
                    'slug'                => $slug, //$weapon->slug,
                    'description'         => $weapon->description,
                    'type'                => $type ?? null,
                    'equip_type'          => $weapon->itemClass[1] ?? null,
                    'tier'                  => empty($weapon->tier) ? null : $weapon->tier,
                    'rarity'                => empty($weapon->rarity) ? null : $weapon->rarity,
                    'required_level'      => empty($weapon->level) ? null : $weapon->level,
                    'gear_score'        => $weapon->gearScore ?? null,
                    'min_gear_score'      => $weapon->gearScoreMin ?? null,
                    'max_gear_score'      => $weapon->gearScoreMax ?? null,
                    'icon'              => $weapon->icon ?? null,
                    
                    'image'             => $weapon->iconHiRes ?? null,
                    'named'             => $weapon->namedItem ?? null,
                    'num_perk_slots'      => count($weapon->perkBuckets) ?? null,
                    'weight'      => $weapon->weight ?? null,
                    'maxStack'      => $weapon->maxStack ?? null,
                    'bindOnPickup'      => $weapon->bindOnPickup ?? null,
                    'bindOnEquip'      => $weapon->bindOnEquip ?? null,
                    'durability'      => $weapon->durability ?? null,
                    'flagCanBeBought'      => $weapon->flagCanBeBought ?? null,

                    'base_damage'      => $weapon->baseDamage ?? null,
                    'stagger_damage'      => $weapon->staggerDamage ?? null,
                    'crit_chance'      => $weapon->CritChance ?? null,
                    'crit_multiplier'      => $weapon->CritDamageMultipler ?? null,                    
                ];
            }

            DB::table( 'base_weapons' )->upsert( $insert, ['slug'] );
        } // end foreach
    }
}
