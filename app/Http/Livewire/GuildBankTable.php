<?php

namespace App\Http\Livewire;

use App\GuildBank;
use App\Models\Companies\Company;
use App\Models\Items\Armor;
use App\Models\Items\Weapon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class GuildBankTable extends DataTableComponent
{
    
    public Company $company;
    protected GuildBank $guildBank;
    
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

//    public string $defaultSortColumn = 'items.gear_score';
//    public string $defaultSortDirection = 'desc';
    
    private array $bindings = [];

    /**
     * constructor is called before company can be set,
     * so use livewire mount() to load the params sent
     * 
     * -- livewire is no longer calling mount() first, so ????
     *      have it create a GuildBank as needed with static constructor
     *      I can't be bothered with the JS BS right now tbh
     *
     * @param \App\GuildBank                     $guildBank
     * @param array                              $armors
     * @param array                              $weapons
     * @param array                              $weight_class
     * @param array                              $types
     * @param array                              $rarity
     * @param array                              $perks
     * @param \App\Models\Companies\Company|null $company
     *
     * @return void
     */
    public function mount(GuildBank $guildBank, array $armors, array $weapons, array $weight_class, array $types, array $rarity, array $perks, Company $company=null)
    {
        $this->guildBank = $guildBank;
        $this->company = $company ?? $this->guildBank->company();
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
            Column::make( 'Name', 'name' )
                ->sortable()
                ->searchable(),
            Column::make( 'Gear Score', 'gear_score' )
                ->sortable(),
            Column::make( 'Perks', 'perks' )
//                ->sortable()
                ->searchable(),
            // type of item
            Column::make( 'Item Type', 'type' )
                ->sortable()
                ->searchable(),
            // kind of weapon/armor
            Column::make( 'Type', 'subtype' )
                ->sortable()
                ->searchable(),
            Column::make( 'Rarity', 'rarity' )
                ->sortable()
                ->searchable(),            
            Column::make( 'Weight Class', 'weight_class' )
                ->sortable()
                ->searchable(),
            Column::make( 'Added At', 'created_at' )
                ->sortable()
         ];
    }
    
    public function rowView(): string
    {
        // do not need to wrap in a <tr> 
         // Becomes /resources/views/location/to/my/row.blade.php
         return 'guild-bank.table-row';
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
        // livewire is no longer respecting mount()...???? so this
        $this->guildBank ??= GuildBank::make(Auth::user()->company() ?? 1);
        
        $query = $this->guildBank->unionQuery();
        $this->bindings = $query->getBindings();
    
        // -- item type filter -- find based on subtypes of weapons or armor
        $query->when($this->getFilter('item_type'), function ($query, $item_type) {
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
        });
        
        // -- perk filter
        /*$query = $query->when($this->getFilter('perks'), 
            function ($query, $perks) {

                // save bindings so that we can attach at the end
                // perks are used twice in the query
                $this->bindings = array_merge($this->bindings, $perks, $perks);
                
                
                return $this->guildBank->joinPerkQuery($query, $this->bindings, $perks);
        });*/
//ddd($query->toSql(),$this->bindings);
//
        $query->orderBy('items.gear_score', 'desc')
            ->orderBy('items.name', 'asc')
        ;
//     
        // manually attach bindings because mergeBindings() does not order them properly
        return $query->setBindings($this->bindings)
        ;
    }
    
    public function getTableRowUrl($row): string
    {
        return route(Str::plural(strtolower($row->type)).'.show', [
            strtolower($row->type)=>$row->slug
        ]);
    }
}
