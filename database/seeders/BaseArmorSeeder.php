<?php

namespace Database\Seeders;

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
            foreach ( $armors as $armor ) {
                
                // create unique slug
                $slug = $armor->name . (!empty($armor->rarity) ? ' '.$armor->rarity : '') . (!empty($armor->tier) ? ' t'.$armor->tier : '') . (!empty($armor->weightClass) ? ' '.$armor->weightClass : '');
                $slug = Str::slug($slug);
            
                $insert [] = [
                    'name'                => $armor->name,
//                    'long_name'           => $armor->name_with_affixes,
                    'json_id'             => $armor->id,
                    'slug'                => $slug, //$armor->slug,
                    'description'         => $armor->description,
                    'type'                => $armor->itemClass[0] ?? null,
                    'weight_class'        => $armor->weightClass ?? null,
                    'tier'                => $armor->tier,
                    'rarity'              => $armor->rarity,
                    'required_level'      => $armor->level ?? null,
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

            DB::table( 'base_armors' )->upsert( $insert, ['slug'] );
        }
    }
}
