<?php

namespace App\Http\Livewire;

use App\GuildBank;
use App\Models\Companies\Company;
use App\Models\Items\Armor;
use App\Models\Items\Weapon;
use Illuminate\Support\Facades\DB;
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

    public string $defaultSortColumn = 'items.name';

    public string $defaultSortDirection = 'asc';
    private array $bindings = [];

    /**
     * constructor is called before company can be set,
     * so use livewire mount() to load the params sent
     *
     * @param \App\GuildBank $guildBank
     * @param array          $armors
     * @param array          $weapons
     * @param array          $weight_class
     * @param array          $types
     * @param array          $rarity
     * @param array          $perks
     *
     * @return void
     */
    public function mount(GuildBank $guildBank, array $armors, array $weapons, array $weight_class, array $types, array $rarity, array $perks)
    {
        $this->guildBank = $guildBank;
        $this->company = $guildBank->company();
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
            Column::make( 'Gear Score', 'gear_score' )
                ->sortable(),
            Column::make( 'Weight Class', 'weight_class' )
                ->sortable()
                ->searchable()
        ];
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
                ->select($this->rarity),
            'perks' => Filter::make('Perk')
                ->multiSelect($this->perks),
        ];
    }

    public function query()
    {
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
        })
        
        // -- perk filter
        ->when($this->getFilter('perks'), function ($query, $perks) {
            
            // save bindings so we can attach at the end
            $this->bindings[]= '%'.implode('%, %',$perks).'%';
            
            return $query->join('perk_weapon', function($join){
                return $join->on('items.id', '=', 'perk_weapon.weapon_id');
            }) 
                ->join('armor_perk', function($join){
                    return $join->on('items.id', '=', 'armor_perk.armor_id');
                }) 
                ->join('perks', function($join) use ($perks) {
                    return $join->on('perks.id', '=', 'perk_weapon.perk_id')
                        ->orOn('perks.id', '=', 'armor_perk.perk_id')
                        ->whereRaw('perks.slug IN 
                            ('.implode(',', 
                                array_fill(0, count($perks), '?')).')');
                })
                ;             
        });
        
        // manually attach bindings because mergeBindings() does not order them properly
        return $query->setBindings($this->bindings)
        ;
    }
}
