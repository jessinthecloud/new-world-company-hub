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
    // search is for the guild bank
    public bool $bank = true;
    // limit search by item type
    public ?string $type = null;
    // limit search by item subtype
    public ?string $subtype = null;

    public function valueSelected($item)
    {
//        $this->emitUp('userSelected', $item);
    }
    
    // TODO: refactor
    public function query() {
    
        if($this->bank){
            return BaseArmor::rawForBankSearch('%'.$this->search.'%')
                ->union(BaseWeapon::rawForBankSearch('%'.$this->search.'%'))
                ->orderBy('name');
        }
        
        if(isset($this->subtype)){
            // only for specific equipment slot
            return match ( $this->type ) {
                "weapon" => BaseWeapon::rawForLoadout( '%' . $this->search . '%', $this->subtype )
                    ->orderBy( 'name' ),
                default => BaseArmor::rawForLoadout( '%' . $this->search . '%', $this->subtype )
                    ->orderBy( 'name' ),
            };
        }
        
        if(isset($this->type)){
            // only for equipment type slot
            return match ( $this->type ) {
                "weapon" => BaseWeapon::rawForSearch( '%' . $this->search . '%' )
                    ->orderBy( 'name' ),
                default => BaseArmor::rawForSearch( '%' . $this->search . '%' )
                    ->orderBy( 'name' ),
            };
        }
        
        return BaseArmor::rawForSearch('%'.$this->search.'%')
                ->union(BaseWeapon::rawForSearch('%'.$this->search.'%'))
                ->orderBy('name');
    }
}