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
            $perks = json_decode( file_get_contents( $file->getPathname() ) );

            $insert = [];
            foreach ( $perks as $perk ) {
                // create unique slug
                $slug = $perk->name;
                $slug = Str::slug( $slug );

                $insert [] = [
                    'name'                => $perk->name,
                    'json_id'             => $perk->id,
                    'slug'                => $slug,
                    'description'         => $perk->description,
                    'perk_type'           => $perk->PerkType ?? null,
                    'tier'                  => $perk->tier ?? null,
                    'rarity'                => $perk->rarity ?? null,
                    'icon'              => $perk->icon ?? null,
                    'image'             => $perk->iconHiRes ?? null,
                    
                    'ScalingPerGearScore'      => $perk->ScalingPerGearScore ?? null,
                    'min_gear_score'      => $perk->gearScoreMin ?? null,
                    'max_gear_score'      => $perk->gearScoreMax ?? null,
                    'condition'      => $perk->condition ?? null,
                ];
            }

            DB::table( 'perks' )->upsert( $insert, ['slug'] );
        } // end foreach
    }
}
