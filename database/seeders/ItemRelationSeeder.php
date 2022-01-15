<?php

namespace Database\Seeders;

use App\Models\Items\BaseArmor;
use App\Models\Items\BaseWeapon;
use App\Models\Items\Perk;
use Illuminate\Database\Seeder;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ItemRelationSeeder extends Seeder
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
        foreach ( $perks as $json_perk ) {
            $items = $json_perk->itemsWithPerk;
            $perk = Perk::where('json_id', $json_perk->id)->first();
//            dump('Perk: '.$perk->name);
//            dump($items);
            foreach($items as $json_item){
                if(isset($json_item->itemType)) {
                    switch ( strtolower($json_item->itemType) ) {
                        case "weapon":
                            $item = BaseWeapon::where('json_id', $json_item->id)->first();
if(empty($item)) dump($item?->name . '('.$json_item->id.')');
                            if(isset($item)){
                                $item->perks()->attach($perk->id);
                            }
                            break;
                        case "armor":
                            $item = BaseArmor::where('json_id', $json_item->id)->first();
if(empty($item)) dump($item?->name . '('.$json_item->id.')');
                            if(isset($item)){
                                $item->perks()->attach($perk->id);
                            }
                            break;
                    }
                }
            } // end foreach item
        } // end foreach perk
    } // end foreach file
    }
}
