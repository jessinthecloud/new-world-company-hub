<?php

namespace App\Http\Livewire;

use App\Models\Items\BaseArmor;
use App\Models\Items\BaseWeapon;
use App\Models\Items\Perk;

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
        return Perk::forSearch('%'.$this->search.'%')
                ->orderBy('name');
    }
    
    public function render()
    {
        return view('livewire.perk-autocomplete');
    }
}