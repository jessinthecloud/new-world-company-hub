<?php

namespace Database\Seeders;

use App\Models\BaseArmor;
use App\Models\Perk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveTreeIterator;

class BaseArmorSeeder extends Seeder
{
    public function run()
    {
        $dir = __DIR__ . '/../../storage/app/json/armors';
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS )
        );
        foreach ( $files as $file ) {
//    dump($file->getPathname());

            $armors = json_decode( file_get_contents( $file->getPathname() ) );

            $insert = [];
            $bucket_perk_ids = [];
            foreach ( $armors as $armor ) {
            

/*$b = collect($armor->perkBuckets)->first()->perks;
dd(
$b,
'perk',collect($b)->pluck('perk'), 
'chance', collect($b)->pluck('chance')
);*/                
                // create unique slug
                $slug = $armor->name 
                    . ( str_contains($armor->id, 'cast') ? ' cast' : '' )
                    . ( str_contains($armor->id, 'drop') ? ' drop' : '' )
                    . ( str_contains($armor->id, 'dynasty') ? ' dynasty' : '' )
                    . ( str_contains($armor->id, 'corrupted') ? ' corrupted' : '' )
                    . (!empty($armor->rarity) ? ' '.$armor->rarity : '') 
                    . (!empty($armor->tier) ? ' t'.$armor->tier : '') 
                    . (!empty($armor->weightClass) ? ' '.$armor->weightClass : '');
                    
                $slug = Str::slug($slug);
                
                // save for batch query later
                foreach ( $armor->perkBuckets as $bucket ) {
                    foreach ( $bucket->perks as $bucket_perk ) {
                        $bucket_perk_ids [$bucket_perk->perk->id]= $bucket_perk->chance;
                    } // end each perk
                } // end each bucket 
            
                $insert [] = [
                    'name'                => $armor->name,
//                    'long_name'           => $armor->name_with_affixes,
                    'json_id'             => $armor->id,
                    'slug'                => $slug, //$armor->slug,
                    'description'         => $armor->description,
                    'type'                => $armor->itemClass[0] ?? null,
                    'weight_class'        => $armor->weightClass ?? null,
                    'tier'                  => empty($armor->tier) ? null : $armor->tier,
                    'rarity'                => empty($armor->rarity) ? null : $armor->rarity,
                    'required_level'      => empty($armor->level) ? null : $armor->level,
                    'gear_score'          => $armor->gearScore ?? null,
                    'min_gear_score'      => $armor->gearScoreMin ?? null,
                    'max_gear_score'      => $armor->gearScoreMax ?? null,
                    'icon'              => $armor->icon ?? null,
                    
                    'image'             => $armor->iconHiRes ?? null,
                    'named'             => $armor->namedItem ?? null,
                    'num_perk_slots'      => count($armor->perkBuckets) ?? null,
                    'weight'      => $armor->weight ?? null,
                    'maxStack'      => $armor->maxStack ?? null,
                    'bindOnPickup'      => $armor->bindOnPickup ?? null,
                    'bindOnEquip'      => $armor->bindOnEquip ?? null,
                    'durability'      => $armor->durability ?? null,
                    'flagCanBeBought'      => $armor->flagCanBeBought ?? null,
                ];
            }

            DB::table( 'base_armors' )->upsert( $insert, ['json_id', 'slug'] );
            
            // attach perks
            foreach($insert as $armor) {

                $baseArmor = BaseArmor::where('json_id', '=', $armor['json_id'])->first();
/*if(!isset($baseArmor)){
    dd('BASE WEAPON NOT DEFINED',$armor['slug'],$armor['json_id']);
}*/                
//dump('attach perks');
                
                $db_perks = Perk::whereIn( 'json_id', array_keys($bucket_perk_ids) )->get();
                $perks = [];
                foreach ( $db_perks as $perk ) {
                    $perks [$perk->id]= ['chance'=>$bucket_perk_ids[$perk->json_id]]; 
                } // end each perk
                
                // batch attach via array of ids and pivot column
                $baseArmor->perks()->attach( $perks );
            } // end each armor
        }
    }
}
