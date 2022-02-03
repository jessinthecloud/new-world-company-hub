<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class BaseArmor extends BaseItem
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];//['perks'];
    

    public function instances()
    {
        return $this->hasMany(Armor::class);
    }
    
    public function sets()
    {
        return $this->belongsToMany(ArmorSet::class);
    }

    
// -- SCOPES
    public function scopeRawForBankSearch(Builder $query, string $term)
    {
        return $this->select(DB::raw('base_armors.id as id, base_armors.slug as slug, base_armors.name as name, base_armors.type as subtype, base_armors.rarity, base_armors.gear_score, base_armors.weight_class, "Armor" as type'))
            ->where('base_armors.name', 'like', $term)
            ->where('named', 0)
            ->where('bindOnPickup', 0)
            // no test items
            ->where('name', 'not like', '@%')
            // no items under tier 5
            ->where('tier', '>=', 5)
        ;
    }
    
    /** @method rawForSearch() */
    public function scopeRawForSearch( Builder $query, string $term )
    {
        return $this->select(DB::raw('base_armors.id as id, base_armors.slug as slug, base_armors.name as name, base_armors.type as subtype, base_armors.rarity, base_armors.gear_score, null as weight_class, "Weapon" as type'))
            ->where('base_armors.name', 'like', $term)
            // no test items
            ->where('name', 'not like', '@%')
        ;
    }


// -- MISC


}