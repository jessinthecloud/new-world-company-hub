<?php

namespace Database\Seeders;

use App\Enums\ArmorType;
use App\Enums\WeaponType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ItemSubtypesSeeder extends Seeder
{
    public function run()
    {
        $weapon_types = WeaponType::toAssociative();
        $armor_types = ArmorType::toAssociative();
        $subtypes = array_merge($weapon_types, $armor_types);
        $upsert = [];
        foreach($subtypes as $json_key => $name){
            $upsert []= [
               'name' => $name,
               'json_key' => $json_key,
               'slug' => Str::slug(strtolower($name)),
               'created_at' => now(),
               'updated_at' => now(),
            ]; 
        }

        DB::table('item_subtypes')->upsert($upsert, ['slug']);
    }
}
