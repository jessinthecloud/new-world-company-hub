<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ConsumableSeeder extends Seeder
{
    public function run()
    {
        $dir = __DIR__ . '/../../storage/app/json/consumables';
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS )
        );
        foreach ( $files as $file ) {
            $consumables = json_decode( file_get_contents( $file->getPathname() ) );

            $insert = [];
            foreach ( $consumables as $consumable ) {
                // create unique slug
                $slug = $consumable->name . ( !empty( $consumable->rarity ) ? ' ' . $consumable->rarity : '' ) . ( !empty( $consumable->tier ) ? ' t' . $consumable->tier : '' );
                $slug = Str::slug( $slug );

                $insert [] = [
                    'name'                => $consumable->name,
                    'long_name'           => $consumable->name_with_affixes,
                    'slug'                => $slug, //$consumable->slug,
                    'description'         => $consumable->parsed_description,
                    'consumable_type'     => $consumable->item_class_en ?? $consumable->item_class,
                    'tier'                => $consumable->tier,
                    'rarity'              => $consumable->rarity,
                    'required_level'      => $consumable->required_level ?? null,
                    'gear_score_override' => $consumable->gear_score_override ?? null,
                    'min_gear_score'      => $consumable->min_gear_score ?? null,
                    'max_gear_score'      => $consumable->max_gear_score ?? null,
                    'cdn_asset_path'      => $consumable->cdn_asset_path ?? null,
                ];
            }

            DB::table( 'consumables' )->upsert( $insert, ['slug'] );
        }
    }
}
