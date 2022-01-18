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
        $dir = __DIR__ . '/../../storage/app/json/items/weapons';
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS )
        );
        foreach ( $files as $file ) {
            dump('unpacking: '.$file->getPathname());

            $weapons = json_decode( file_get_contents( $file->getPathname() ) );
//dd($data);
           
            $insert = [];
            $bucket_perk_ids = [];
            foreach ( $weapons as $weapon ) {
                $weapon=$weapon->data;

                // create unique slug
                $slug = ( !empty( $weapon->itemClass[2] ) ? $weapon->itemClass[2] . ' ' : '' )
                    . $weapon->name
                    . ( !empty( $weapon->rarity ) ? ' ' . $weapon->rarity : '' ) 
                    . ( !empty( $weapon->tier ) ? ' t' . $weapon->tier : '' );
                
                $slug = Str::slug( $slug );
                
                // see if slug exists
                // in table 
                $bw = BaseWeapon::where('slug', 'like' , $slug.'%')->count();
                // in pending inserts
                $iw = collect( $insert )->pluck('slug')->filter(function($value, $key) use ($slug){
//        dump(' ---  ',$value);
//                    if(is_string($value)) dump('-- INNER -- key: '.$key.' -- value: '.$value.' -- slug to match: '.$slug);
                    // find duplicate slugs that may not be exact match
                    $match = (is_string($value) && str_contains($value, $slug));
                    if($match) dump ('*** MATCH ***', $value, $slug);
                    return $match;
                })->count();
/*if(str_contains($slug, 'defiled-tower')) {
    dump(
        '

',
//        collect( $insert )->pluck( 'slug' )->all(),
        'slug: '.$slug. ' name: '.$weapon->name. ' type: '.$weapon->itemClass[2].' --> '. $type. ' json id: '.$weapon->id,
        ' 
        LIKE : ',collect( $insert )->pluck('slug')->filter(function($value, $key) use ($slug){
//        dump(' ---  ',$value);
                    if(is_string($value)) dump('-- INNER -- key: '.$key.' -- value: '.$value.' -- slug to match: '.$slug);
                    // find duplicate slugs that may not be exact match
                    $match = (is_string($value) && str_contains($value, $slug));
                    if($match) dump ('*** MATCH ***');
                    return $match;
                })->all(),
        'EQUAL : ',collect( $insert )->where( 'slug', '=', $slug )->pluck('slug')->all(),
        '

'
    );
} */               
                $newslug = $slug;
                if($bw > 0){
//                dump('SLUG '.$slug.' EXISTS in DATABASE --'.$bw.'-- times');
                    $newslug = $slug.'-x'.($bw+1);
//                    dump('new slug: '.$newslug);
                }
                if($iw > 0){
//                dump('SLUG '.$slug.' EXISTS in PENDING --'.$iw.'-- times');
                    $newslug = $slug.'-x'.($bw+$iw+1);
//                    dump('new slug: '.$newslug);
                }
                
                $slug = $newslug;
               
                $type = $weapon->itemClass[2] ?? null;
                $type = (isset($type) && $type == '2HHammer') ? 'WarHammer' : $type; 
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
                    'slug'                => strtolower($slug),
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
/*    if(str_contains($slug, 'defiled-tower')){
        dump("
        -- SLUG FOUND --
        ", $slug, 'name: '.$weapon->name, 'type: '.$weapon->itemClass[2].' --> '. $type, 'json id: '.$weapon->id );
    }*/
            } // end foreach weapon
            
            DB::table( 'base_weapons' )->upsert( $insert, ['json_id', 'slug'] );

            // attach perks
            foreach($insert as $weapon) {

                $baseWeapon = BaseWeapon::where('json_id', '=', $weapon['json_id'])->first();
if(!isset($baseWeapon)){
    dd('BASE WEAPON NOT DEFINED','base weapon: ',$baseWeapon, 'name: '.$weapon['name'], 'type: '.$weapon['type'], 'slug: '.$weapon['slug'], 'json id: '.$weapon['json_id']);
}                
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
