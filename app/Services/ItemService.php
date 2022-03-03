<?php

namespace App\Services;

use App\Enums\Rarity;
use App\Enums\WeightClass;
use App\Models\Items\BaseItem;
use App\Models\Items\Perk;

class ItemService
{
    /**
     * @param Perk[]|null $perks     array of Perks
     *
     * @return string
     */
    public function perkOptions( array $perks=null ) : string
    {
        $perks ??= Perk::asArrayForDropDown();

        return Perk::selectOptions($perks);
    }
    
    /**
     * @param array $item_perks array of Perks or Perk slug strings
     * @param array $perks      
     *
     * @return array
     */
    public function existingPerkOptions( array $item_perks, array $perks ) : array
    {
        $existing_perk_options = [];
        $i=0;
        foreach($item_perks as $perk){
            // allow $item_perks to be array of slugs
            $slug = ($perk instanceof Perk) ? $perk->slug : $perk;
            
            $existing_perk_options [$i]= '<option value=""></option>';
            foreach($perks as $value => $text) {
                $existing_perk_options [$i].= '<option value="'.$value.'"';
                    if($value == $slug){
                        $existing_perk_options [$i].= ' SELECTED ';
                    }
                $existing_perk_options [$i].= '>'.$text.'</option>';
            }
            $i++;
        }
        
        return $existing_perk_options;
    }
    
    // TODO: setup like perkOptions()
    public function rarityOptions( string $rarity='' ) : string
    {
        $rarity_options = '<option value=""></option>';
        foreach(Rarity::cases() as $type) {
            $rarity_options .= '<option value="'.$type->name.'"';
                if(strtolower($type->value) == strtolower($rarity)){
                    $rarity_options .= ' SELECTED ';
                }
            $rarity_options .= '>'.$type->value.'</option>';
        }
        
        return $rarity_options;
    }
    
    // base item info for autocomplete dropdown
    // TODO: update
    // TODO: setup like perkOptions()
    public function baseItemsOptions(InventoryItemContract $item=null, bool $for_bank=true) : string
    {
        $base_item = $this->getAllBaseItems($for_bank);

        $base_item_options = '<option value=""></option>';
        foreach($base_item as $value => $text) {
            $base_item_options .= '<option value="'.$value.'"';
            if($value == $item?->base?->slug){
//dump('base slug: '.$value .' == '.$item?->base?->slug);
                    $base_item_options .= ' SELECTED ';
                }
            $base_item_options .= '>'.$text.'</option>';
        }
        
        return $base_item_options;
    }
    
    public function baseItem($id) : BaseItem
    {
        // TODO: implement/update
    }
    
    public function initGenericItemAttributes( array $validated, array $values, BaseItem $base=null ) : array
    {
        // TODO: implement/update
    }
    
    public function initItemAttributes( array $validated, OldBaseItem $base = null )
    {
        // TODO: implement/update
    }

    public function saveSpecificItemRelations( array $validated, InventoryItemContract $item, OldBaseItem $base=null )
    {
        // TODO: implement/update        
    }
    
    public function createSpecificItem(array $validated, OldBaseItem $base=null)
    {
        // TODO: implement/update 
    }
    
    public function updateSpecificItem(array $validated, InventoryItemContract $item, OldBaseItem $base=null)
    {
        // TODO: implement/update 
    }
    
    public function createInventoryItem( $item, $owner )
    {
        // TODO: implement/update 
    }
    
    public function updateInventoryItem( $item, $owner )
    {
        // TODO: implement/update 
    }
}