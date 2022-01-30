<?php

namespace App\Http\Livewire;

use App\GuildBank;
use App\Models\Companies\Company;
use App\Models\CompanyInventory;
use App\Models\Items\Armor;
use App\Models\Items\InventoryItem;
use App\Models\Items\Weapon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class InventoryTable extends DataTableComponent
{
    
    public $owner;
    
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
     * constructor is called before company can be set,
     * so use livewire mount() to load the params sent
     * 
     * -- livewire is no longer calling mount() first, so ????
     *      have it create a GuildBank as needed with static constructor
     *      I can't be bothered with the JS BS right now tbh
     *
     * @param \App\Models\Companies\Company|\App\Models\Characters\Character|null $owner
     * @param array                              $armors
     * @param array                              $weapons
     * @param array                              $weight_class
     * @param array                              $types
     * @param array                              $rarity
     * @param array                              $perks
     *
     * @return void
     */
    public function mount($owner, array $armors, array $weapons, array $weight_class, array $types, array $rarity, array $perks)
    {
        if(!empty(session('inventory-'.$this->owner->name.'-filters'))){
            $this->filters = session('inventory-'.$this->owner->name.'-filters');
        }
        $this->company = $owner;
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
            Column::make( 'Name', 'item.itemable.name' )
                ->sortable(),
            Column::make( 'Gear Score', 'item.itemable.gear_score' )
                ->sortable(),
            Column::make( 'Perks', 'item.itemable.perks' ),
            // type of item
            Column::make( 'Item Type', 'item.itemable.type' )
                ->sortable(),
            // kind of weapon/armor
            Column::make( 'Type', 'item.itemable_type' )
                ->sortable(),
            Column::make( 'Rarity', 'item.itemable.rarity' )
                ->sortable(),
            Column::make( 'Weight Class', 'item.itemable.weight_class' )
                ->sortable(),
            Column::make( 'Added At', 'item.itemable.created_at' )
                ->sortable()
         ];
    }
    
    /*public function rowView(): string
    {
        // do not need to wrap in a <tr> 
         // Becomes /resources/views/location/to/my/row.blade.php
         return 'inventory.table-row';
    }*/
    
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
//    dd(InventoryItem::ownedBy($this->owner)->forTable()->get());   
        return InventoryItem::ownedBy($this->owner)->forTable();
        
        // livewire is no longer respecting mount()...???? so this
//        $this->guildBank ??= GuildBank::make(Auth::user()->company() ?? Company::find(1));
        
        /*$query = $this->guildBank->unionQuery();
        $this->bindings = $query->getBindings();
    
        // -- item type filter -- find based on subtypes of weapons or armor
        $query = $query->when($this->getFilter('item_type'), function ($query, $item_type) {
            // save bindings so we can attach at the end
            $this->bindings []= '%'.$item_type.'%';

            return $query->whereRaw('items.type like ?');
        })

        // -- weapon filter
        ->when($this->getFilter('weapon_type'), function ($query, $weapon_type) {
            // save bindings so we can attach at the end
            $this->bindings[]= '%'.$weapon_type.'%';
            
            return $query->whereRaw( 'items.subtype like ?');
        })

        // -- armor filter
        ->when($this->getFilter('armor_type'), function ($query, $armor_type) {
            // save bindings so we can attach at the end
            $this->bindings[]= '%'.$armor_type.'%';
            
            return $query->whereRaw('items.subtype like ?');
        })
        
        // -- weight class filter
        ->when($this->getFilter('weight_class'), function ($query, $weight_class) {
            // save bindings so we can attach at the end
            $this->bindings[]= '%'.$weight_class.'%';
            
            return $query->whereRaw('items.weight_class like ?');
        })
        
        // -- rarity filter
        ->when($this->getFilter('rarity'), function ($query, $rarity) {
            // save bindings so we can attach at the end
            $this->bindings[]= '%'.$rarity.'%';
            
            return $query->whereRaw('items.rarity like ?');
        })
        // search filter
        ->when($this->getFilter('search'), function ($query, $term) {
            // save bindings so we can attach at the end
            $this->bindings[]= strtolower('%'.$term.'%');
            $this->bindings[]= strtolower('%'.$term.'%');
            $this->bindings[]= strtolower('%'.$term.'%');
            $this->bindings[]= strtolower('%'.$term.'%');
            $this->bindings[]= strtolower('%'.$term.'%');
            
            return $query->whereRaw( 'LOWER(items.name) like ?' )
                ->orWhereRaw( 'LOWER(items.type) like ?' )
                ->orWhereRaw( 'LOWER(items.subtype) like ?' )
                ->orWhereRaw( 'LOWER(items.rarity) like ?' )
                ->orWhereRaw( 'LOWER(items.weight_class) like ?' );
        });
        
        
        // manually attach bindings because mergeBindings() does not order them properly
        return $query->setBindings($this->bindings)
        ;*/
    }
    
    /*public function getTableRowUrl($row): string
    {
        return route(Str::plural(strtolower($row->type)).'.show', [
            strtolower($row->type)=>$row->slug
        ]);
    }*/
}
