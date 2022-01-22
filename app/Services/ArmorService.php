<?php

namespace App\Services;

use App\Enums\ArmorType;
use App\Enums\WeightClass;
use App\Models\Items\Armor;
use App\Models\Items\BaseArmor;
use App\Models\Items\BaseItem;
use Illuminate\Support\Str;

class ArmorService extends ItemService implements ItemServiceContract
{
    protected string $itemClass = Armor::class;
    protected string $baseItemClass = BaseArmor::class;
    
    public function __construct() {
        
    }
    
    /**
     * @return array
     */
    public function getAllBaseItems() : array
    {
        return BaseArmor::bankable()->orderBy('name')->orderBy('tier')->distinct()
            ->orderBy('name')/*->dd()->toSql();*/
            ->get()->mapWithKeys(function($base_armor){
        
            $wtype = $base_armor->type;
            $type = !empty($wtype) ? constant("App\Enums\ArmorType::$wtype")->value : null;
        
            return [$base_armor->slug => $base_armor->name . " (".(!empty($base_armor->weight_class) ? $base_armor->weight_class.' ' : '').$type.") Tier ".$base_armor->tier];
        })->all();
    }

    /**
     * @return string
     */
    public function weightClassOptions() : string
    {
        $weight_class_options = '<option value="">None</option>';
        foreach(WeightClass::cases() as $type) {
            $weight_class_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $weight_class_options;
    }

    /**
     * @return string
     */
    public function itemTypeOptions() : string
    {
        $armor_type_options = '<option value=""></option>';
        foreach(collect(ArmorType::cases())->sortBy('value')->all() as $type) {
            $armor_type_options .= '<option value="'.$type->name.'">'.$type->value.'</option>';
        }
        
        return $armor_type_options;
    }

    /**
     * @param array                           $validated
     * @param \App\Models\Items\BaseItem|null $base
     *
     * @return mixed
     */
    public function createItem( array $validated, BaseItem $base = null )
    {
        // get base armor
        $base ??= $this->baseItem($validated['armor']);

        $name = $validated['name'] ?? $base->name;
        $description = $validated['description'] ?? $base?->description ?? null;
        $gear_score = $validated['gear_score'] ?? $validated['armor_gear_score'] 
            ?? $base->gear_score ?? null;
        
        $rarity_input = $validated['rarity'];
        $rarity = !empty($rarity_input) 
            ? constant("App\Enums\Rarity::$rarity_input")?->value 
            : $base->rarity ?? null;
            
        $tier_input = $validated['tier'];
        $tier = !empty($tier_input) 
            ? constant("App\Enums\Tier::$tier_input")?->value 
            : $base?->tier ?? null;
            
        $type_input = $validated['armor_type'];
        $type = !empty($type_input) 
            ? constant("App\Enums\ArmorType::$type_input")?->value 
            : $base->type ?? null;
            
        $weight_class = !empty($validated['weight_class']) 
            ? WeightClass::from($validated['weight_class'])->name 
            : null;
            
        $values = [
            'name' => $name,
            'type' => $type,
            'description' => $description,
            'tier' => $tier,
            'rarity' => $rarity,
            'gear_score' => $gear_score,
            'weight_class' => $weight_class,
       ];
            
        // determine unique slug
        $values ['slug']= $this->createUniqueSlug($values);
        
dump('created slug: '.$values ['slug']);        
       
       return Armor::create($values);
    }
}