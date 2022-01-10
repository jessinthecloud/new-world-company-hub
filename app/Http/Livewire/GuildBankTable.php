<?php

namespace App\Http\Livewire;

use App\Enums\ArmorType;
use App\Enums\WeaponType;
use App\Models\Armor;
use App\Models\Weapon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\GuildBank;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class GuildBankTable extends DataTableComponent
{
    
    public GuildBank $guildBank;
    
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

    /**
     * constructor is called before company can be set,
     * so use livewire mount() to load the params sent
     *
     * @param \App\Models\GuildBank $guildBank
     * @param array                 $armors
     * @param array                 $weapons
     * @param array                 $types
     *
     * @return void
     */
    public function mount(GuildBank $guildBank, array $armors, array $weapons, array $types)
    {
        $this->guildBank = $guildBank;
        $this->armor_types = $armors;
        $this->weapon_types = $weapons;
        $this->itemTypes = $types;
        $this->types = ['weapon'=>$this->weapon_types, 'armor'=>$this->armor_types];
    }
    
    public function columns(): array
    {
    
        return [
            Column::make( 'Name', 'name' )
                ->sortable()
                ->searchable(),
            Column::make( 'Type', 'type' )
                ->sortable()
                ->searchable(),
            Column::make( 'Type', 'type' )
                ->sortable()
                ->searchable(),
            Column::make( 'Rarity', 'rarity' )
                ->sortable()
                ->searchable(),
            Column::make( 'Gear Score', 'gear_score' )
                ->sortable()
                ->searchable(),
            Column::make( 'Weight Class', 'weight_class' )
                ->sortable()
                ->searchable()
                ->hideIf( !isset($this->guildBank->armor) || count($this->guildBank->armor) == 0),
            Column::make( 'Perks', 'perks' )
                ->sortable()
                ->searchable(),
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
        ];
    }

    public function query(): Builder
    {
        return Weapon::select(DB::raw('id, name, type, rarity, gear_score, null as weight_class'))
            ->whereRelation( 'banks', 'guild_banks.id', $this->guildBank->id )
        ->union(Armor::select('id', 'name', 'type', 'rarity', 'gear_score', 'weight_class')
            ->whereRelation( 'banks', 'guild_banks.id', $this->guildBank->id ))
        
        // -- item type filter -- find based on subtypes of weapons or armor
        ->when($this->getFilter('item_type'), fn ($query, $item_type) => 
            $query->whereIn('type', $this->types[strtolower($this->itemTypes[$item_type])])        
        )
        
        // -- weapon filter
        ->when($this->getFilter('weapon_type'), fn ($query, $weapon_type) => 
            $query->where(function($query) use ($weapon_type){
                return $query
                    ->where('type', 'like', $weapon_type);
            })
        )
        
        // -- armor filter
        ->when($this->getFilter('armor_type'), fn ($query, $armor_type) => 
            $query->where(function($query) use ($armor_type){
                return $query
                    ->where('type', 'like', $armor_type);
            })
        )
        ;
    }
}
