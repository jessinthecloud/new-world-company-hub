<?php

namespace App\Http\Livewire;

use App\Enums\WeaponType;
use App\Models\Weapon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filter;

class WeaponsTable extends DataTableComponent
{
    public function columns() : array
    {
        return [
            Column::make( 'Name', 'name' )
                ->sortable()
                ->searchable(),
            Column::make( 'Description', 'description' )
                ->sortable()
                ->searchable(),
            Column::make( 'Type', 'weapon_type' )
                ->sortable()
                ->searchable(),
            Column::make( 'Tier', 'tier' )
                ->sortable()
                ->searchable(),
            Column::make( 'Rarity', 'rarity' )
                ->sortable()
                ->searchable(),
        ];
    }
    
    public function filters(): array
    {
        return [
            'type' => Filter::make('Type')
                ->select(collect(WeaponType::cases())->pluck('value')->all()),
            /*'weapon' => Filter::make('Weapon')
                ->select($this->weapons),*/
        ];
    }

    public function query() : Builder
    {
        return Weapon::query()
            // -- class filter --
            ->when($this->getFilter('type'), fn ($query, $type) => 
            $query->where('weapon_type', 'like', $type));
            
            /*/ -- weapon filter -- match the weapon filter to main hand or offhand
            ->when($this->getFilter('weapon'), fn ($query, $weapon) => 
                $query->where(function($query) use ($weapon){
                    return $query
                        ->whereRelation('loadout.main', 'id', $weapon)
                        ->orWhereRelation('loadout.offhand', 'id', $weapon);
                })
            );*/
    }
}
