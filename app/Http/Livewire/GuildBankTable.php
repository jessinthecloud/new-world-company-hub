<?php

namespace App\Http\Livewire;

use App\Enums\ArmorType;
use App\Enums\Rarity;
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
    public array $weight_class;
    public array $types;
    public array $rarity;
    
    public string $defaultSortColumn = 'name';
    public string $defaultSortDirection = 'asc';

    private array $bindings = [];

    /**
     * constructor is called before company can be set,
     * so use livewire mount() to load the params sent
     *
     * @param \App\Models\Company company
     * @param array $armors
     * @param array $weapons
     * @param array $weight_class
     * @param array $types
     * @param array $rarity
     *
     * @return void
     */
    public function mount(Company $company, array $armors, array $weapons, array $weight_class, array $types, array $rarity)
    {
        $this->company = $company;
        $this->armor_types = $armors;
        $this->weapon_types = $weapons;
        $this->weight_class = $weight_class;
        $this->rarity = $rarity;
        $this->itemTypes = $types;
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
                ->sortable()
                ->searchable(),
            Column::make( 'Weight Class', 'weight_class' )
                ->sortable()
                ->searchable()
                ->hideIf( !isset($this->company->armor) || count($this->company->armor) == 0),
            /*Column::make( 'Perks', 'items.perks' )
                ->sortable()
                ->searchable(),*/
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
        ];
    }

    public function query()
    {
        $weapons_query = Weapon::select(DB::raw('weapons.id as id, name, type as subtype, rarity, gear_score, null as weight_class, "Weapon" as type'))
        ->whereRelation('company', 'id', $this->company->id);
        
        $union = Armor::select(DB::raw('armors.id as id, name, type as subtype, rarity, gear_score, weight_class, "Armor" as type'))
        ->whereRelation('company', 'id', $this->company->id)
        ->union($weapons_query);
        
        // create derived table so that we can filter on the union as a whole
        $query = DB::table(DB::raw("({$union->toSql()}) as items"));
        $this->bindings = $union->getBindings();
    
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
        
//        ddd($query->toSql(), $this->bindings);
        // manually attach bindings because mergeBindings() does not order them properly
        return $query->setBindings($this->bindings)
        ;
    }
}
