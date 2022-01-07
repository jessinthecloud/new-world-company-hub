<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArmorSeeder extends Seeder
{
    public function run()
    {
        $data = json_decode(file_get_contents(__DIR__.'/../../storage/app/json/armor/armor-1.json'));
    
//        dump(collect($data->subjects->data)->pluck('attributes')); // armor data
//        dump(collect($data->subjects->data)->pluck('attributes')->pluck('item_class_en')->unique()->all()); // armor type
        
        $armors = collect($data->subjects->data)->pluck('attributes');
        
        $insert = [];
        foreach($armors as $armor){
            $insert []= [
                'name' => $armor->name,
                'long_name' => $armor->name_with_affixes,
                'slug' => $armor->slug, //Str::slug($armor->name),
                'description' => $armor->description,
                'armor_type' => Str::before($armor->item_class_en, '('),
                'weight_class' => Str::beforeLast(Str::after($armor->item_class_en, '('), ')') ?? null,
                'tier' => $armor->tier,
                'rarity' => $armor->rarity,
                'gear_score_override' => $armor->gear_score_override ?? null,
                'min_gear_score' => $armor->min_gear_score ?? null,
                'max_gear_score' => $armor->max_gear_score ?? null,
                'cdn_asset_path' => $armor->cdn_asset_path ?? null,
            ];
        }
        
        DB::table('armors')->insert( $insert );
    }
}
