<?php

namespace App\Http\Livewire;

use App\Models\Items\BaseArmor;
use App\Models\Items\BaseWeapon;

/**
 * Modified from:
 * @author Chris DiCarlo
 * @see https://chrisdicarlo.ca/blog/-alpinejs-and-livewire-autocomplete/
 */
class ItemAutocomplete extends Autocomplete
{
    protected $listeners = ['valueSelected'];

    public function valueSelected($item)
    {
//        $this->emitUp('userSelected', $item);
        
    }

    public function query() {
        return BaseArmor::rawForBankSearch('%'.$this->search.'%') 
                ->union(BaseWeapon::rawForBankSearch('%'.$this->search.'%'))
                ->orderBy('name');
    }
}