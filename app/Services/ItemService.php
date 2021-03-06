<?php

namespace App\Services;

use App\Contracts\InventoryItemContract;
use App\Enums\AttributeType;
use App\Enums\Rarity;
use App\Enums\Tier;
use App\Models\Items\Attribute;
use App\Models\Items\BaseItem;
use App\Models\Items\InventoryItem;
use App\Models\Items\Item;
use App\Models\Items\Perk;
use Illuminate\Support\Str;

abstract class ItemService implements ItemServiceContract
{
    /**
     * @param array|null $perks     array of Perks
     * @param array      $selected  array of slugs of selected perks 
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

    /**
     * @param array $item_attributes - array of Attributes or array of Attribute slug strings
     * @param array $attributes      - array of AttributeType sorted by value
     * @param array $amounts         - optionally pass amounts as array of integers
     *
     * @return array[]
     */
    public function existingAttributeOptions( array $item_attributes, array $attributes, array $amounts=[] ) : array
    {
        $existing_attribute_options = [];
        $existing_attribute_amounts = [];
        $i=0;
        foreach($item_attributes as $attribute){
            // allow $item_attributes to be an array of strings
            $name = ($attribute instanceof Attribute) ? $attribute->name : $attribute;
            $amount = ($attribute instanceof Attribute) ? $attribute->pivot->amount : ($amounts[$i] ?? 0);
       
            $existing_attribute_amounts [$i]= $amount;
            $existing_attribute_options [$i]= '<option value=""></option>';
            foreach($attributes as $type) {
                $existing_attribute_options [$i].= '<option value="'.$type->name.'"';
                    if($type->name == $name){
                        $existing_attribute_options [$i].= ' SELECTED ';
                    }
                $existing_attribute_options [$i].= '>'.$type->value.'</option>';
            }
            $i++;
        }
         
        return [$existing_attribute_amounts, $existing_attribute_options];
    }

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

    public function tierOptions( string $tier ='' )
    {
        $tier_options = '<option value=""></option>';
        foreach(Tier::cases() as $type) {
            $tier_options .= '<option value="'.$type->name.'"';
                if(strtolower($type->name) == strtolower('t'.$tier)){
                    $tier_options .= ' SELECTED ';
                }
            $tier_options .= '>'.$type->value.'</option>';
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
     * @param \App\Contracts\InventoryItemContract|null $item
     *
     * @return string
     */
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
    
    /**
     * @param string $itemType
     *
     * @return string
     */
    public function itemTypeOptions( string $itemType ) : string
    {
        $enum = 'App\\Enums\\'.$itemType.'Type';
        $item_type_options = '<option value=""></option>';
        foreach ( collect( $enum::cases() )->sortBy( 'value' )->all() as $type ) {
            $item_type_options .= '<option value="' . $type->name . '"';
            if ( strtolower( $type->value ) == strtolower( $itemType ) ) {
                $item_type_options .= ' SELECTED ';
            }
            $item_type_options .= '>' . $type->value . '</option>';
        }

        return $item_type_options;
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
         $db_slugs = $this->itemClass::similarSlugs($slug.'%')->orderBy('slug')->get();

         $slug_count = $db_slugs->count();
        
        if( !$db_slugs->contains($old_slug) && $slug_count > 0 ){
            // the found slug is not from the item we're editing,
            // so make this one unique
            
            // we can't rely on the DB order because the string 10 comes before 9
            // make sure we only order by the number after -x
            $db_slugs = $db_slugs->sort(function($slugA, $slugB){
                $suffixA = intval(Str::afterLast($slugA->slug, '-x'));
                $suffixB = intval(Str::afterLast($slugB->slug, '-x'));
                if ($suffixA == $suffixB) {
                    return 0;
                }
                return ($suffixA < $suffixB) ? -1 : 1;
            });
          
            $slug_number = Str::afterLast($db_slugs->last()->slug, '-x');
            $slug .= '-x'.(intval($slug_number)+1);
        }
        return $slug;
    }

    public function isCustomSlug( string $slug )
    {
//        return (Str::after);
    }

    public function initGenericItemAttributes( array $validated, array $values, BaseItem $base=null ) : array
    {
  
        $values['name']= $validated['name'] ?? $base->name;
        $values['description']= $validated['description'] ?? $base?->description ?? null;
        $values['gear_score']= $validated['gear_score'] ?? $validated['weapon_gear_score'] 
            ?? $validated['armor_gear_score'] ?? $base->gear_score ?? null;
        
        $rarity_input = $validated['rarity'];
        $values['rarity']= !empty($rarity_input) 
            ? Rarity::from($rarity_input)?->value 
            : $base->rarity ?? null;
            
        $tier_input = $validated['tier'];
        $values['tier']= !empty($tier_input) 
            ? constant("App\Enums\Tier::$tier_input")?->value 
            : $base?->tier ?? null;
            
        // determine unique slug
        $values ['slug']= $this->createUniqueSlug($values, $validated['slug']);

        return $values;
    }

    /**
     * @param string $slug
     *
     * @return \App\Models\Items\BaseItem|null
     */
    public function baseItemBySlug(string $slug) : ?BaseItem
    {
        // make sure the slug is a match even when it has a dupe
        // don't mistake last - segment for a dupe 
        $condition = ['slug', 'like', Str::beforeLast($slug, '-x').'%'];
        
        return $this->baseItemClass::where(...$condition)->first();
    }
    
    /**
     * @param string $slug
     *
     * @return \App\Models\Items\BaseItem|null
     */
    public function baseItem($id) : ?BaseItem
    {
        return $this->baseItemClass::where('id', '=', $id)->firstOrFail();
    }

    /**
     * @param array                                $validated
     * @param \App\Contracts\InventoryItemContract $item
     * @param \App\Models\Items\BaseItem|null      $base
     *
     * @return \App\Contracts\InventoryItemContract
     */
    public function saveSpecificItemRelations( array $validated, InventoryItemContract $item, BaseItem $base=null )
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
                $item->itemAttributes()->sync( $attrs_to_sync);
            }
        }
        
        $item->save();
        
        return $item;
    }
    
    public function createSpecificItem(array $validated, BaseItem $base=null)
    {
        return $this->itemClass::create(
            $this->initItemAttributes($validated, $base)
        );
    }
    
    public function updateSpecificItem(array $validated, InventoryItemContract $item, BaseItem $base=null)
    {
        $item->update(
            $this->initItemAttributes($validated, $base)
        );
        
        return $item;
    }

    public function createMorphableItem( $specificItem )
    {
        return Item::create([
            'itemable_type' => $specificItem::class,
            'itemable_id' => $specificItem->id,
        ]);
    }
    
    public function createInventoryItem( $item, $owner )
    {
        return InventoryItem::create([
            'item_id' => $item->id,
            'ownerable_type' => $owner::class,
            'ownerable_id' => $owner->id,
        ]);
    }
    
    public function updateMorphableItem( $specificItem )
    {
        $specificItem->asItem->update([
            'itemable_type' => $specificItem::class,
            'itemable_id' => $specificItem->id,
        ]);
        
        return $specificItem->asItem;
    }
    
    public function updateInventoryItem( $item, $owner )
    {
        $item->inventory->update([
            'item_id' => $item->id,
            'ownerable_type' => $owner::class,
            'ownerable_id' => $owner->id,
        ]);
        
        return $item->inventory;
    }
}