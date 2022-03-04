<?php

namespace App\Http\Livewire;

use App\Models\Items\OldBaseArmor;
use App\Models\Items\OldBaseWeapon;

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
    public string $equipSlotName;

    public function valueSelected($item)
    {
//        $this->emitUp('userSelected', $item);
    }
    
    // TODO: refactor
    public function query() {
        // tell the search algorithm to ignore this data for now
        $ignore = [/*'of', 'the', */'of the Soldier', 'of the Fighter', 'of the Spellsword', 'of the Barbarian', 'of the Monk', 'of the Cavalier', 'of the Ranger', 'of the Assassin', 'of the Brigand', 'of the Duelist', 'of the Battlemage', 'of the Trickster', 'of the Scholar', 'of the Occultist', 'of the Mage', 'of the Knight', 'of the Warden', 'of the Druid', 'of the Sentry', 'of the Nomad', 'of the Zealot', 'of the Artificer', 'of the Priest', 'of the Cleric', 'of the Sage', 'Abyssal', 'Electrified', 'Empowered', 'Ignited', 'Frozen', 'Arboreal', 'Brash', 'Opportunistic', 'Vengeful', 'Exhilarating', 'Cruel', 'Scheming', 'Rallying', 'Abyssal', 'Fireproof', 'Iceproof', 'Insulated', 'Empowered', 'Arboreal', 'Burnished', 'Padded', 'Tempered', 'Reinforced', 'Primeval', 'Imbued', 'Spectral', 'Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Burning', 'Standard', 'Fine', 'Superior', 'Artisan', 'Flawless', 'Worn', 'Infused'];
        $term = str_ireplace($ignore, '', $this->search);
        $term = str_replace(' ', '%', trim($term));
        $term = '%'.trim($term,'%').'%';
//    dump($term);
        if($this->bank){
            return OldBaseArmor::rawForBankSearch($term)
                ->union(OldBaseWeapon::rawForBankSearch($term))
                ->orderBy('name');
        }
        
        if(isset($this->subtype)){
            // only for specific equipment slot
            return match ( $this->type ) {
                "weapon" => OldBaseWeapon::rawForLoadout($term, $this->subtype )
                    ->orderBy( 'name' ),
                default => OldBaseArmor::rawForLoadout($term, $this->subtype )
                    ->orderBy( 'name' ),
            };
        }
        
        if(isset($this->type)){
            // only for equipment type slot
            return match ( $this->type ) {
                "weapon" => OldBaseWeapon::rawForSearch($term )
                    ->orderBy( 'name' ),
                default => OldBaseArmor::rawForSearch($term )
                    ->orderBy( 'name' ),
            };
        }
        
        return OldBaseArmor::rawForSearch($term)
                ->union(OldBaseWeapon::rawForSearch($term))
                ->orderBy('name');
    }
}