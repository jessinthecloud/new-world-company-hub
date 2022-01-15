<?php

namespace Database\Seeders;

use App\Models\Items\BaseWeapon;
use App\Models\Items\Perk;
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
            $bucket_perk_ids = [];
            foreach ( $weapons as $weapon ) {
                // create unique slug
                $slug = $weapon->name
                    . ( str_contains($weapon->id, 'cast') ? ' cast' : '' )
                    . ( str_contains($weapon->id, 'drop') ? ' drop' : '' )
                    . ( str_contains($weapon->id, 'dynasty') ? ' dynasty' : '' )
                    . ( str_contains($weapon->id, 'corrupted') ? ' corrupted' : '' )
                    . ( !empty( $weapon->rarity ) ? ' ' . $weapon->rarity : '' ) 
                    . ( !empty( $weapon->tier ) ? ' t' . $weapon->tier : '' );
                
                $slug = Str::slug( $slug );
               
                $type = $weapon->itemClass[2] ?? null;
                $type = (isset($type) && $type == '2HHammer') ? 'WarHammer' : $type; 
                $type = (isset($type) && $type == '2HAxe') ? 'GreatAxe' : $type;
                
                // save for batch query later
                foreach ( $weapon->perkBuckets as $bucket ) {
                    foreach ( $bucket->perks as $bucket_perk ) {
                        $bucket_perk_ids [$bucket_perk->perk->id]= $bucket_perk->chance;
                    } // end each perk
                } // end each bucket 

                $insert []= [
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
/*    if($slug == "defiled-hatchet-t5"){
        dump("
        -- SLUG FOUND --
        ", $slug, $weapon->id, $weapon->name);
    }*/
            } // end foreach weapon
            DB::table( 'base_weapons' )->upsert( $insert, ['json_id', 'slug'] );

            // attach perks
            foreach($insert as $weapon) {

                $baseWeapon = BaseWeapon::where('json_id', '=', $weapon['json_id'])->first();
/*if(!isset($baseWeapon)){
    dd('BASE WEAPON NOT DEFINED',$weapon['slug'],$weapon['json_id']);
}*/                
//dump('attach perks');
                
                $db_perks = Perk::whereIn( 'json_id', array_keys($bucket_perk_ids) )->get();
                $perks = [];
                foreach ( $db_perks as $perk ) {
                    $perks [$perk->id]= ['chance'=>$bucket_perk_ids[$perk->json_id]]; 
                } // end each perk
                
                // batch attach via array of ids and pivot column
                $baseWeapon->perks()->attach( $perks );
            } // end each weapon
            
//            dd(
//                reset(collect($weapon->perkBuckets)->first()->perks)
//                );
            
        } // end foreach file
    }
}
