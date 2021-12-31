<?php

namespace App\Http\Livewire;

use App\Models\Character;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class CompanyTable extends DataTableComponent
{

    public Company $company;

    public function __construct( $id = null )
    {
        parent::__construct( $id );
    }
    
    // construct is called before company can be set,
    // so use livewire mount() to load
    // the company param sent
    public function mount(Company $company)
    {
        $this->company = $company;
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
            Column::make( 'Name', 'loadout.main.name' )
                ->sortable()
                ->searchable(),
            Column::make( 'Name', 'loadout.offhand.name' )
                ->sortable()
                ->searchable(),
        ];
    }

    public function query() : Builder
    {
        return Character::with('loadout')->whereRelation( 'company', 'id', $this->company->id );
    }
}
