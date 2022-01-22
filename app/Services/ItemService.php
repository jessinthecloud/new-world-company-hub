<?php

namespace App\Services;

use App\Contracts\InventoryItemContract;
use App\Enums\AttributeType;
use App\Enums\Rarity;
use App\Enums\Tier;
use App\Models\Items\Attribute;
use App\Models\Items\BaseArmor;
use App\Models\Items\BaseItem;
use App\Models\Items\Perk;
use App\Models\Items\Weapon;
use Illuminate\Support\Str;

abstract class ItemService implements ItemServiceContract
{
    public function perkOptions(  ) : string
    {
        $perks = Perk::orderBy('name')->distinct()->get()->mapWithKeys(function($perk){
            return [$perk->slug => $perk->name];
        })->all();

        $perk_options = '<option value=""></option>';
        foreach($perks as $value => $text) {
            $perk_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        return $perk_options;
    }

    public function rarityOptions(  ) : string
    {
        $rarity_options = '<option value=""></option>';
        foreach(Rarity::cases() as $type) {
            $rarity_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $rarity_options;
    }

    public function tierOptions(  )
    {
        $tier_options = '<option value=""></option>';
        foreach(Tier::cases() as $type) {
            $tier_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $tier_options;
    }

    public function attributeOptions(  )
    {
        $attribute_options = '<option value=""></option>';
        foreach(collect(AttributeType::cases())->sortBy('value')->all() as $type) {
            $attribute_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $attribute_options;
    }
    
    /**
     * @return string
     */
    public function baseItemsOptions() : string
    {
        $base_item = $this->getAllBaseItems();

        $base_item_options = '<option value=""></option>';
        foreach($base_item as $value => $text) {
            $base_item_options .= '<option value="'.$value.'">'.$text.'</option>';
        }
        
        return $base_item_options;
    }
    
    /**
     *
     * @param array       $fields
     * @param string|null $old_slug  if we are editing, make sure the slug retrieved isn't from this item
     *
     * @return string
     */
    public function createUniqueSlug(array $fields, string $old_slug=null) : string
    {
        $slug = $fields['type'] . ' ' . $fields['name'] . ' ' 
            . ( !empty( $fields['rarity'] ) ? ' ' . $fields['rarity'] : '' ) 
            . ( !empty( $fields['tier'] ) ? ' t' . $fields['tier'] : '' )
            . ( !empty( $fields['weight_class'] ) ? ' ' . $fields['weight_class'] : '' )
        ;
        $slug = Str::slug( $slug );
        // see if slug exists in table 
         $db_slugs = $this->itemClass::similarSlugs($slug.'%')->get();

         $slug_count = $db_slugs->count();
        
dump("db slugs:",$db_slugs,$slug.'%',"slug before checking: $slug", "slug count: $slug_count");        
        
        if( !$db_slugs->contains($old_slug) && $slug_count > 0 ){
            // the found slug is not from the item we're editing,
            // so make this one unique
            $slug .= '-x'.($slug_count+1);
        }

        return $slug;
    }
    
    /**
     * @param string $slug
     *
     * @return \App\Models\Items\BaseItem
     */
    public function baseItem(string $slug) : BaseItem
    {
        return $this->baseItemClass::where('slug', $slug)->first();
    }

    /**
     * @param array                                $validated
     * @param \App\Contracts\InventoryItemContract $item
     * @param string                               $company_id
     *
     * @return \App\Contracts\InventoryItemContract
     */
    public function saveItemRelations( array $validated, InventoryItemContract $item, string $company_id )
    {
        if(isset($base)) {
            // attach to base item
            $item->base()->associate($base);
            $item->save();
        }
        
        // attach perks
        $perks = Perk::whereIn('slug', $validated['perks'])->get();

        if(!empty(array_filter($perks->pluck('id')->all()))) {
            $item->perks()->sync(array_filter($perks->pluck('id')->all()));
        }
        
        // attach attributes
        if(!empty(array_filter($validated['attrs']))) {
            $attrs = [];
            $amounts = [];
            foreach(array_filter($validated['attrs']) as $key => $attr){
                $attr_slug = constant("App\Enums\AttributeType::$attr")?->value;
                $attrs []= $attr_slug;
                $amounts [strtolower($attr_slug)]= $validated['attribute_amounts'][$key];
            }
      
            $attributes = Attribute::whereIn( 'slug', $attrs)->get();

            if ( !empty( $attributes->pluck( 'id' )->all() ) ) {
                $attrs_to_sync = [];
                // also attach with amounts
                foreach($attributes as $attribute){
                    $attrs_to_sync [$attribute->id] = ['amount' => $amounts[$attribute->slug]];
                }
                $item->attributes()->sync($attrs_to_sync);
            }
        }
        
        // attach to bank
        $item->company()->associate($company_id);
        $item->save();
        
        return $item;
    }
}