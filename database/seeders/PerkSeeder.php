<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class PerkSeeder extends Seeder
{
    public function run()
    {
        $dir = __DIR__ . '/../../storage/app/json/perks';
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS )
        );
        foreach ( $files as $file ) {
        dump('unpacking: '.$file->getPathname());
            $perks = json_decode( file_get_contents( $file->getPathname() ) );

            $insert = [];
            foreach ( $perks as $perk ) {
                $perk=$perk->data;
                // create unique slug
                $slug = Str::slug( $perk->name );

                $insert [] = [
                    'name'                => $perk->name,
                    'json_id'             => $perk->id,
                    'slug'                => $slug,
                    'description'         => $perk->description,
                    'perk_type'           => $perk->PerkType ?? null,
                    'tier'                  => empty($perk->tier) ? null : $perk->tier,
                    'rarity'                => empty($perk->rarity) ? null : $perk->rarity,
                    'icon'              => $perk->icon ?? null,
                    'image'             => $perk->iconHiRes ?? null,
                    
                    'ScalingPerGearScore'      => $perk->ScalingPerGearScore ?? null,
                    'min_gear_score'      => $perk->gearScoreMin ?? null,
                    'max_gear_score'      => $perk->gearScoreMax ?? null,
                    'condition'      => $perk->condition ?? null,
                ];
//dump($perk->name, $perk->id);
            } // end each perks
            DB::table( 'perks' )->upsert( $insert, ['json_id','slug'] );
        } // end foreach
    }
}
