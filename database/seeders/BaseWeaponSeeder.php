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
        $dir = __DIR__ . '/../../storage/app/json/weapon';
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS )
        );
        foreach ( $files as $file ) {
            $data = json_decode( file_get_contents( $file->getPathname() ) );

            $weapons = collect( $data->subjects->data )->pluck( 'attributes' );

            $insert = [];
            foreach ( $weapons as $weapon ) {
                // create unique slug
                $slug = $weapon->name . ( !empty( $weapon->rarity ) ? ' ' . $weapon->rarity : '' ) . ( !empty( $weapon->tier ) ? ' t' . $weapon->tier : '' );
                $slug = Str::slug( $slug );

                $insert [] = [
                    'name'                => $weapon->name,
                    'long_name'           => $weapon->name_with_affixes,
                    'slug'                => $slug, //$weapon->slug,
                    'description'         => $weapon->parsed_description,
                    'weapon_type'         => $weapon->item_class_en ?? $weapon->item_class,
                    'tier'                => $weapon->tier,
                    'rarity'              => $weapon->rarity,
                    'required_level'      => $weapon->required_level ?? null,
                    'gear_score_override' => $weapon->gear_score_override ?? null,
                    'min_gear_score'      => $weapon->min_gear_score ?? null,
                    'max_gear_score'      => $weapon->max_gear_score ?? null,
                    'cdn_asset_path'      => $weapon->cdn_asset_path ?? null,
                ];
            }

            DB::table( 'base_weapons' )->upsert( $insert, ['slug'] );
        } // end foreach
    }
}
