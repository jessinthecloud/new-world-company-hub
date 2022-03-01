<?php

namespace App\Http\Livewire;

use App\Models\Items\OldBaseArmor;
use App\Models\Items\OldBaseWeapon;
use App\Models\Items\OldPerk;

/**
 * Modified from:
 * @author Chris DiCarlo
 * @see https://chrisdicarlo.ca/blog/-alpinejs-and-livewire-autocomplete/
 */
class PerkAutocomplete extends Autocomplete
{
    protected $listeners = ['valueSelected'];

    public function valueSelected($item)
    {
//        $this->emitUp('userSelected', $item);
    }

    public function query() {        
        return OldPerk::forSearch('%'.$this->search.'%')
                ->orderBy('name');
    }
    
    public function render()
    {
        return view('livewire.perk-autocomplete');
    }
}