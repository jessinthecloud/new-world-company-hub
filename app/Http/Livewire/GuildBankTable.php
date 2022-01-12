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
use App\Models\Company;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class GuildBankTable extends DataTableComponent
{
    
    public Company $company;
    
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
    
    // debugging
    public bool $dumpFilters = true;

    /**
     * constructor is called before company can be set,
     * so use livewire mount() to load the params sent
     *
     * @param \App\Models\Company company
     * @param array                 $armors
     * @param array                 $weapons
     * @param array                 $types
     *
     * @return void
     */
    public function mount(Company $company, array $armors, array $weapons, array $types)
    {
        $this->company = $company;
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
                ->hideIf( !isset($this->company->armor) || count($this->company->armor) == 0),
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
            'gear_score' => Filter::make('Gear Score')
                ->select(['Any','221'=>221,'341'=>341]),
        ];
    }

    public function query()
    {
//    dump($this->getFilter('weapon_type'));
        $weapons_query = Weapon::select(DB::raw('weapons.id as id, name, type, rarity, gear_score, null as weight_class'))
        ->join('guild_banks', function ($join) {
            $join->on('weapons.id', '=', 'guild_banks.item_id')
                 ->where('guild_banks.item_type', '=', 'App\Models\Weapon')
                 ->where('guild_banks.company_id', '=', $this->company->id)
                 ;
        });
        
        $union = Armor::select(DB::raw('armors.id as id, name, type, rarity, gear_score, weight_class'))
        ->join('guild_banks', function ($join) {
            $join->on('armors.id', '=', 'guild_banks.item_id')
                 ->where('guild_banks.item_type', '=', 'App\Models\Armor')
                 ->where('guild_banks.company_id', '=', $this->company->id)
                 ;
        })
        ->union($weapons_query);
        // create derived table so we can filter on the union as a whole
        $query = DB::table(DB::raw("({$union->toSql()}) as items"));
        $union_bindings = $union->getBindings();

        $query = $query->when($this->getFilter('gear_score'), function ($query, $gear_score) use ($union_bindings, $union) {
            $query = $query->whereRaw(
                'items.gear_score = ?'
            );
            
//            dump($query->toSql(), $query->getBindings(), $union_bindings);
            $union_bindings[] = $gear_score;
//            $query->setBindings($union_bindings);
//            ddd($query->toSql(), $query->getBindings(), $union_bindings);
            // TODO: need to pass bindings back out
            return $query;
        });
        
        
    
        // -- item type filter -- find based on subtypes of weapons or armor
        /*->when($this->getFilter('item_type'), fn ($query, $item_type) => 
            $query->whereIn('type', $this->types[strtolower($this->itemTypes[$item_type])])        
        )
        
        // -- weapon filter
        ->when($this->getFilter('weapon_type'), function ($query, $weapon_type) {
            return $query->where( 'type', 'like', $weapon_type );
        })
        
        // -- armor filter
        ->when($this->getFilter('armor_type'), fn ($query, $armor_type) => 
            $query->where('type', 'like', $armor_type)
        )
        */
        ddd($query->toSql(), $union_bindings);
        return $query->setBindings($union_bindings)
        ;
    }
}
