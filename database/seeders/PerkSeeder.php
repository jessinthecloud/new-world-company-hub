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
            $data = json_decode( file_get_contents( $file->getPathname() ) );

            $perks = collect( $data->subjects->data );

            $insert = [];
            foreach ( $perks as $perk ) {
                // create unique slug
                $slug = $perk->attributes->name;
                $slug = Str::slug( $slug );

                $insert [] = [
                    'name'                => $perk->attributes->name,
                    'json_id'                => $perk->id,
                    'slug'                => $slug, //$perk->attributes->slug,
                    'description'         => $perk->attributes->parsed_description,
                    'perk_type'           => $perk->attributes->perk_type,
                    'item_class'           => $perk->attributes->item_class_en ?? $perk->attributes->item_class,
                    'cdn_asset_path'      => $perk->attributes->asset_path ?? null,
                ];
            }

            DB::table( 'perks' )->upsert( $insert, ['slug'] );
        } // end foreach
    }
}
