<?php

namespace App\Http\Livewire;

use App\Models\Weapon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\GuildBank;

class WeaponBankTable extends DataTableComponent
{

    public GuildBank $guildBank;
    
    // passed in as Collections and then made arrays
    public $armors;
    public $weapons;
    
    /**
     * constructor is called before company can be set,
     * so use livewire mount() to load the params sent
     *
     * @param \App\Models\Company            $company
     * @param \Illuminate\Support\Collection $armors
     * @param \Illuminate\Support\Collection $weapons
     *
     * @return void
     */
    public function mount(GuildBank $guildBank, Collection $armors, Collection $weapons)
    {
        $this->guildBank = $guildBank;
        dump($this->guildBank->id);
        dump(Weapon::whereRelation( 'banks', 'guild_bank_id', $this->guildBank->id )->toSql());
        
        // add "Any" to the front of the filter arrays
        $weapons->prepend('Any', '');

        $this->weapons = $weapons->all();
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
            Column::make( 'Rarity', 'rarity' )
                ->sortable()
                ->searchable(),
            Column::make( 'Gear Score', 'gear_score' )
                ->sortable()
                ->searchable(),
        ];
    }

    public function query(): Builder
    {
        return Weapon::whereRelation( 'banks', 'guild_banks.id', $this->guildBank->id );
    }
}
