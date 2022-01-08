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
        $dir = __DIR__ . '/../../storage/app/json/armor';
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator( $dir, RecursiveDirectoryIterator::SKIP_DOTS )
        );
        foreach ( $files as $file ) {
//    dump($file->getPathname());

            $data = json_decode( file_get_contents( $file->getPathname() ) );

//        dump(collect($data->subjects->data)->pluck('attributes')); // armor data
//        dump(collect($data->subjects->data)->pluck('attributes')->pluck('item_class_en')->unique()->all()); // armor type

            $armors = collect( $data->subjects->data )->pluck( 'attributes' );

            $insert = [];
            foreach ( $armors as $armor ) {
                // separate weight class
                $weight_class = Str::contains($armor->item_class_en, '(') ? Str::beforeLast( Str::after( $armor->item_class_en, '(' ), ')' ) : null;
                // create unique slug
                $slug = $armor->name . (!empty($armor->rarity) ? ' '.$armor->rarity : '') . (!empty($armor->tier) ? ' t'.$armor->tier : '') . (!empty($weight_class) ? ' '.$weight_class : '');
                $slug = Str::slug($slug);
            
                $insert [] = [
                    'name'                => $armor->name,
                    'long_name'           => $armor->name_with_affixes,
                    'slug'                => $slug, //$armor->slug,
                    'description'         => $armor->parsed_description,
                    'type'                => isset($armor->item_class_en) ? Str::before( $armor->item_class_en, '(' ) : $armor->item_class,
                    'weight_class'        => $weight_class,
                    'tier'                => $armor->tier,
                    'rarity'              => $armor->rarity,
                    'required_level'      => $armor->required_level ?? null,
                    'gear_score_override' => $armor->gear_score_override ?? null,
                    'min_gear_score'      => $armor->min_gear_score ?? null,
                    'max_gear_score'      => $armor->max_gear_score ?? null,
                    'cdn_asset_path'      => $armor->cdn_asset_path ?? null,
                ];
            }

            DB::table( 'base_armors' )->upsert( $insert, ['slug'] );
        }
    }
}
