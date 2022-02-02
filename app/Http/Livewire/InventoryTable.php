<?php

namespace App\Http\Livewire;

use App\Models\Items\Armor;
use App\Models\Items\InventoryItem;
use App\Models\Items\Item;
use App\Models\Items\Weapon;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class InventoryTable extends DataTableComponent
{
    
    public $owner;
    public $inventory;

    // passed in as Collections and then made arrays
    /**
     * @var Armor[]
     */
    public array $armor_types;
    /**
     * @var Weapon[]
     */
    public array $weapon_types;
    /**
     * @var string[]
     */
    public array $itemTypes;
    public array $weight_class;
    public array $types;
    public array $rarity;
    public array $perks;

//    public string $defaultSortColumn = 'gear_score';
//    public string $defaultSortDirection = 'desc';
    
    private array $bindings = [];
    
    public bool $dumpFilters = false;

    /**
     * constructor is called before owner can be set,
     * so use livewire mount() to load the params sent
     *
     * @param \App\Models\Companies\Company|\App\Models\Characters\Character|null $owner
     * @param                                                                     $inventory
     * @param array                                                               $armors
     * @param array                                                               $weapons
     * @param array                                                               $weight_class
     * @param array                                                               $types
     * @param array                                                               $rarity
     * @param array                                                               $perks
     *
     * @return void
     */
    public function mount($owner, $inventory, array $armors, array $weapons, array $weight_class, array $types, array $rarity, array $perks)
    {
    
        if(!empty(session('inventory-'.$this->owner->name.'-filters'))){
            $this->filters = session('inventory-'.$this->owner->name.'-filters');
        }
        $this->owner = $owner;
        $this->inventory = $inventory;
        $this->armor_types = $armors;
        $this->weapon_types = $weapons;
        $this->weight_class = $weight_class;
        $this->rarity = $rarity;
        $this->itemTypes = $types;
        $this->perks = $perks;
    }
    
    public function columns(): array
    {
        return [
            Column::make( 'Name', 'item.itemable.name' ),
//                ->sortable(),
            Column::make( 'Gear Score', 'item.itemable.gear_score' ),
//                ->sortable(),
            Column::make( 'Perks', 'item.itemable.perks' ),
            Column::make( 'Attributes', 'item.itemable.attributes' ),
            // type of item
            Column::make( 'Item Type', 'item.itemable.type' ),
//                ->sortable(),
            // kind of weapon/armor
            Column::make( 'Type', 'item.itemable_type' ),
//                ->sortable(),
            Column::make( 'Rarity', 'item.itemable.rarity' ),
//                ->sortable(),
            Column::make( 'Weight Class', 'item.itemable.weight_class' ),
//                ->sortable(),
            Column::make( 'Added At', 'item.itemable.created_at' )
//                ->sortable()
         ];
    }
    
    public function rowView(): string
    {
        // do not need to wrap in a <tr> 
        // Becomes /resources/views/location/to/my/row.blade.php
        return 'inventory.table-row';
    }
    
    public function resetFilters() : void
    {
        parent::resetFilters();
        
        // clear session filters
        session()->forget('inventory-'.$this->owner->name.'-filters');
    }
    
    public function updatedFilters() : void
    {
        parent::updatedFilters();
        
        // keep track of filters across requests
        session()->put('inventory-'.$this->owner->name.'-filters', $this->filters);
    }

    public function filters(): array
    {    
        return [
            'item_type' => Filter::make('Item Type')
                ->select($this->itemTypes),
            'weapon_type' => Filter::make('Weapon Type')
                ->select($this->weapon_types),
            'armor_type' => Filter::make('Armor Type')
                ->select($this->armor_types),
            'weight_class' => Filter::make('Weight Class')
                ->select($this->weight_class),
            'rarity' => Filter::make('Rarity')
                ->select($this->rarity)
        ];
    }

    public function query()
    {
  
        return InventoryItem::ownedBy($this->owner)->forTable()
            // -- item type filter -- find based on subtypes of weapons or armor
            ->when($this->getFilter('item_type'), function ($query, $item_type) {    
                return $query->whereRelation(
                    'item', 'itemable_type', 'like', '%'.$item_type.'%'
                );
            })
            
            // -- weapon type filter -- find based on subtypes of weapons
            ->when($this->getFilter('weapon_type'), function ($query, $weapon_type) {    
                return $query
                    ->whereRelation('item', function($query) use ($weapon_type) {
                        return $query->whereMorphRelation(
                            'itemable', 
                            'App\\Models\\Items\\Weapon', 
                            'type', 
                            'like', 
                            '%'.$weapon_type.'%'
                        );
                    });
            })
            
            // -- armor type filter -- find based on subtypes of armor
            ->when($this->getFilter('armor_type'), function ($query, $armor_type) {    
                return $query
                    ->whereRelation('item', function($query) use ($armor_type) {
                        return $query->whereMorphRelation(
                            'itemable', 
                            'App\\Models\\Items\\Armor', 
                            'type', 
                            'like', 
                            '%'.$armor_type.'%'
                        );
                    });
            })
            
            // -- weight_class filter
            ->when($this->getFilter('weight_class'), function ($query, $weight_class) {    
                return $query
                    ->whereRelation('item', function($query) use ($weight_class) {
                        return $query->whereMorphRelation(
                            'itemable', 
                            'App\\Models\\Items\\Armor', 
                            'weight_class', 
                            'like', 
                            '%'.$weight_class.'%'
                        );
                    });
            })
            
            // -- rarity filter
            ->when($this->getFilter('rarity'), function ($query, $rarity) {    
                return $query
                    ->whereRelation('item', function($query) use ($rarity) {
                        return $query->whereMorphRelation(
                            'itemable', 
                            '*', 
                            'rarity', 
                            'like', 
                            '%'.$rarity.'%'
                        );
                    });
            })
            
            // -- search filter
            ->when($this->getFilter('search'), function ($query, $term) {    
                return $query
                    ->whereRelation('item', function($query) use ($term) {
                        return $query->whereMorphRelation(
                            'itemable', 
                            '*', 
                            'type', 
                            'like', 
                            '%'.$term.'%'
                        )
                        ->orWhereMorphRelation(
                            'itemable', 
                            '*', 
                            'rarity', 
                            'like', 
                            '%'.$term.'%'
                        )
                        ->orWhereMorphRelation(
                            'itemable', 
                            'App\\Models\\Items\\Armor',
                            'weight_class', 
                            'like', 
                            '%'.$term.'%'
                        )
                        ->orWhereMorphRelation(
                            'itemable', 
                            '*', 
                            'name', 
                            'like', 
                            '%'.$term.'%'
                        )
                        ;
                    });
            });
    }
    
    public function getTableRowUrl($row): string
    {
        $type = Str::afterLast(strtolower($row->item->itemable_type), '\\');
        return route(Str::plural($type).'.show', [
            $type=>$row->item->itemable->slug
        ]);
    }
}
