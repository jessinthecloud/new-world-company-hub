<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class BaseItemSeeder extends Seeder
{
    public function run()
    {
        $select = ['ItemID', 'Name', 'ItemType', 'ItemTypeDisplayName', 'Description', 'ItemClass', 'TradingCategory', 'TradingFamily', 'TradingGroup', 'BindOnPickup', 'BindOnEquip', 'GearScoreOverride', 'MinGearScore', 'MaxGearScore', 'Tier', 'ItemStatsRef', 'GrantsHWMBump', 'IgnoreNameChanges', 'CanHavePerks', 'CanReplaceGem', 'Perk1', 'Perk2', 'Perk3', 'Perk4', 'Perk5', 'PerkBucket1', 'PerkBucket2', 'PerkBucket3', 'PerkBucket4', 'PerkBucket5', 'ForceRarity', 'RequiredLevel', 'UseTypeAffix', 'UseMaterialAffix', 'UseMagicAffix', 'IconCaptureGroup', 'UiItemClass', 'RDyeSlotDisabled', 'GDyeSlotDisabled', 'BDyeSlotDisabled', 'ADyeSlotDisabled', 'ArmorAppearanceM', 'ArmorAppearanceF', 'WeaponAppearanceOverride', 'ConfirmDestroy', 'ConfirmBeforeUse', 'ConsumeOnUse', 'PrefabPath', 'HousingTags', 'IconPath', 'HiResIconPath', 'MaxStackSize', 'DeathDropPercentage', 'Nonremovable', 'IsMissionItem', 'IsUniqueItem', 'ContainerLevel', 'ContainerGS', 'ExceedMinIndex', 'ExceedMaxIndex', 'IsSalvageable', 'SalvageResources', 'IsRepairable', 'RepairDustModifier', 'RepairRecipe', 'CraftingRecipe', 'RepairGameEventID', 'SalvageGameEventID', 'SalvageAchievement', 'RepairTypes', 'IngredientCategories', 'IngredientBonusPrimary', 'IngredientBonusSecondary', 'IngredientGearScoreBaseBonus', 'IngredientGearScoreMaxBonus', 'ExtraBonusItemChance', 'Durability', 'DurabilityDmgOnDeath', 'DestroyOnBreak', 'Weight', 'AcquisitionNotificationId', 'AudioPickup', 'AudioPlace', 'AudioUse', 'AudioCreated', 'AudioDestroyed', 'MannequinTag', 'SoundTableID', 'WarboardGatherStat', 'WarboardDepositStat', 'Notes', 'HideInLootTicker', ];
        
        $base_items = DB::table('MasterItemDefinitions_Common')->select($select)
            ->union(DB::table('MasterItemDefinitions_Crafting')->select($select))
            ->union(DB::table('MasterItemDefinitions_Faction')->select($select))
            ->union(DB::table('MasterItemDefinitions_Loot')->select($select))
            ->union(DB::table('MasterItemDefinitions_Named')->select($select))
            ->union(DB::table('MasterItemDefinitions_Omega')->select($select))
            ->union(DB::table('MasterItemDefinitions_Quest')->select($select))
            ->union(DB::table('MasterItemDefinitions_Store')->select($select))
            ->get()
            ;
//dump($base_items[0], $base_items->count());
        $upsert = [];
        $base_item_perks = [];
        foreach ( $base_items as $base_item_array ) {
            
            $base_item_array = (array)$base_item_array;
            
            $base_item_name = !empty($base_item_array['DisplayName']) 
                ? $base_item_array['DisplayName'] 
                : $base_item_array['ItemID'];
            // type
            $base_item_type_id = DB::table('item_types')
                ->where('name', $base_item_array['ItemType'])
                ->first()?->id;
            // subtype
            $base_item_subtype_id = DB::table('item_subtypes')
                ->where('name', $base_item_array['ItemTypeDisplayName'])
                ->first()?->id;
            // tier
            $tier_id = DB::table('tiers')
                ->where('number', $base_item_array['Tier'])
                ->first()?->id;
                
            // determine if named (perk buckets are empty)
            $named = 0;
            if(
                empty($base_item_array['PerkBucket1'])
                && empty($base_item_array['PerkBucket2'])
                && empty($base_item_array['PerkBucket3'])
                && empty($base_item_array['PerkBucket4'])
                && empty($base_item_array['PerkBucket5'])
            ) {
                // no perk buckets means curated roll, means named item
                $named = 1;
            }
            
            // find perks & save for later
            $perks = DB::table('perks')
                ->whereIn('json_key', array_filter([
                    $base_item_array['Perk1'],
                    $base_item_array['Perk2'],
                    $base_item_array['Perk3'],
                    $base_item_array['Perk4'],
                    $base_item_array['Perk5']
                ]))
                ->get();
            $base_item_perks [$base_item_array['ItemID']]=$perks;

            $row = [
                'name'         => $base_item_name,
                'slug'         => Str::slug($base_item_array['ItemID']),
                'json_key'     => $base_item_array['ItemID'],
                'item_type_id' => $base_item_type_id,
                'item_subtype_id' => $base_item_subtype_id,
                'tier_id'      => $tier_id ?? null,
                'named' => $named,
            ];

            // make sure corresponding column exists in table
            $base_item_array = collect($base_item_array)->filter(function ($value, $key) {
                return Schema::hasColumn('base_items', Str::snake($key)) && $key != 'id';
            })->all();

            // format like column names 
            $keys = array_map(function ($key) {
                return Str::snake($key);
            }, array_keys($base_item_array));

            $base_item_array = array_combine($keys, array_values($base_item_array));

            // combine generic data with bespoke array  
            $insert = array_merge($base_item_array, $row);

            $upsert []= $insert;
//dd($upsert);
        } // end each perks

        foreach(array_chunk($upsert, 2000) as $upsert_array){
            DB::table('base_items')->upsert($upsert_array, ['json_key']);
        }
        
        /**
         * attach perks
         */
        $perk_insert = [];
        $base_items = DB::table('base_items')
            ->select(['id','json_key'])
            ->whereIn('json_key', array_keys($base_item_perks))
            ->get();

        foreach($base_items as $base_item){
            $perk_insert []= [
                'base_item_id' => $base_item->id,
                'perk_id' => $base_item_perks[$base_item->json_key]->id,
            ];
        }
        
        DB::table('base_item_perk')->upsert($perk_insert, ['base_item_id', 'perk_id']);
    }
}
