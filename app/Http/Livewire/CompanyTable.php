<?php

namespace App\Http\Livewire;

use App\Models\Characters\Character;
use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class CompanyTable extends DataTableComponent
{
    // debugging
//    public bool $dumpFilters = true;
    
    public Company $company;
    
    // passed in as Collections and then made arrays
    public $classes;
    public $weapons;    
     
    /**
     * constructor is called before company can be set,
     * so use livewire mount() to load the params sent
     *
     * @param \App\Models\Companies\Company  $company
     * @param \Illuminate\Support\Collection $classes
     * @param \Illuminate\Support\Collection $weapons
     *
     * @return void
     */
    public function mount(Company $company, Collection $classes, Collection $weapons)
    {
        $this->company = $company;
        
        // add "Any" to the front of the filter arrays
        $classes->prepend('Any', '');
        $weapons->prepend('Any', '');

        $this->classes = $classes->all();
        $this->weapons = $weapons->all();
    }

    public function columns() : array
    {
        return [
            Column::make( 'Name', 'name' )
                ->sortable()
                ->searchable(),
            Column::make( 'Discord Name', 'user.discord_name' )
                ->sortable()
                ->searchable(),
            Column::make( 'Class', 'class.name' )
                ->sortable()
                ->searchable(),
            /*Column::make( 'Main Hand', 'loadout.main.name' )
                ->sortable()
                ->searchable(),
            Column::make( 'Offhand', 'loadout.offhand.name' )
                ->sortable()
                ->searchable(),*/
        ];
    }
    
    public function filters(): array
    {
        return [
            'class' => Filter::make('Class')
                ->select($this->classes),
            'weapon' => Filter::make('Weapon')
                ->select($this->weapons),
        ];
    }

    public function query() : Builder
    {
        return Character::whereRelation( 'company', 'id', $this->company->id )
            
            // -- class filter --
            ->when($this->getFilter('class'), fn ($query, $class) => $query->whereRelation('class', 'id', $class))
            
            // -- weapon filter -- match the weapon filter to main hand or offhand
            /*->when($this->getFilter('weapon'), fn ($query, $weapon) => 
                $query->where(function($query) use ($weapon){
                    return $query
                        ->whereRelation('loadout.main', 'id', $weapon)
                        ->orWhereRelation('loadout.offhand', 'id', $weapon);
                })
            )*/
            ;
    }
}
