<?php

namespace App\Http\Livewire;

use App\Models\Characters\Character;
use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
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
     
    /**
     * constructor is called before company can be set,
     * so use livewire mount() to load the params sent
     *
     * @param \App\Models\Companies\Company  $company
     * @param \Illuminate\Support\Collection $classes
     *
     * @return void
     */
    public function mount(Company $company, Collection $classes)
    {
        $this->company = $company;
        
        // add "Any" to the front of the filter arrays
        $classes->prepend('Any', '');

        $this->classes = $classes->all();
    }

    public function columns() : array
    {
        return [
            Column::make( 'War Ready', 'character.loadout.approved' ),
            Column::make( 'Name', 'name' )
                ->sortable()
                ->searchable(),
            Column::make( 'Discord Name', 'user.discord_name' )
                ->searchable(),
            Column::make( 'Class', 'class.name' )
                ->searchable(),
            Column::make( 'Registered', 'character.created_at' ),
        ];
    }
    
    public function rowView(): string
    {
        // do not need to wrap in a <tr> 
         // Becomes /resources/views/location/to/my/row.blade.php
         return 'company.table-row';
    }
    
    public function filters(): array
    {
        return [
            'class' => Filter::make('Class')
                ->select($this->classes),
            'gear' => Filter::make('Gear')
                ->select([''=>'Any', 'war'=>'War Ready']),
        ];
    }

    public function query() : Builder
    {
        return Character::with('user', 'class', 'loadout')->whereRelation( 'company', 'id', $this->company->id )
            
            // -- class filter --
            ->when($this->getFilter('class'), fn ($query, $class) => $query->whereRelation('class', 'id', $class))
            
            // -- war ready filter --
            ->when($this->getFilter('gear'), fn ($query, $gearCheck) => $query->whereHas('loadout.gearCheck'))
            ;
    }
    
    public function getTableRowUrl($row): string
    {
        return isset($row->loadout) ? route('loadouts.show', [
            'loadout'=>$row->loadout->id,
        ]) : '#';
    }
}
