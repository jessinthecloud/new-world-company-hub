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
    public bool $bank = true;

    public function valueSelected($item)
    {
//        $this->emitUp('userSelected', $item);
    }

    public function query() {
        if($this->bank){
            return BaseArmor::rawForBankSearch('%'.$this->search.'%')
                ->union(BaseWeapon::rawForBankSearch('%'.$this->search.'%'))
                ->orderBy('name');
        }
        
        return BaseArmor::rawForSearch('%'.$this->search.'%')
                ->union(BaseWeapon::rawForSearch('%'.$this->search.'%'))
                ->orderBy('name');
    }
}