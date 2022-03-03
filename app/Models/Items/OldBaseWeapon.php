<?php

namespace App\Models\Items;

use App\Models\Characters\Loadout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class OldBaseWeapon extends OldBaseItem
{
    use HasFactory;
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];
    
    public function instances()
    {
        return $this->hasMany(Weapon::class);
    }
    
    public function sets()
    {
        return $this->belongsToMany(WeaponSet::class);
    }
    
    public function mainLoadout()
    {
        return $this->hasMany(Loadout::class, 'main_hand_id');
    }

    public function offhandLoadout()
    {
        return $this->hasMany(Loadout::class, 'offhand_id');
    }
    
// -- SCOPES
    /** @method rawForBankSearch() */
    public function scopeRawForBankSearch( Builder $query, string $term )
    {
        return $this->select(DB::raw('base_weapons.id as id, base_weapons.slug as slug, base_weapons.name as name, base_weapons.type as subtype, base_weapons.rarity, base_weapons.gear_score, null as weight_class, "Weapon" as type'))
            ->where('base_weapons.name', 'like', $term)
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
        return $query->select(DB::raw('base_weapons.id as id, base_weapons.slug as slug, base_weapons.name as name, base_weapons.type as subtype, base_weapons.rarity, base_weapons.gear_score, null as weight_class, "Weapon" as type'))
            ->distinct()
            ->where('base_weapons.name', 'like', $term)
            // no test items
            ->where('name', 'not like', '@%')
        ;
    }
    
    /**
     * @method rawForLoadout()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $term - to search for
     * @param string                                $type - item subtype to limit by 
     *
     * @return mixed
     */
    public function scopeRawForLoadout( Builder $query, string $term, string $type )
    {
        return $query->select(DB::raw('base_weapons.id as id, base_weapons.slug as slug, base_weapons.name as name, base_weapons.type as subtype, base_weapons.rarity, base_weapons.gear_score, null as weight_class, "Weapon" as type'))
            ->distinct()
            ->where('base_weapons.name', 'like', $term)
            // only for specific equipment slot
            ->where('type', '=', $type)
            // no test items
            ->where('name', 'not like', '@%')
        ;
    }
    
    /**
     * @method forLoadout()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $term - to search for
     * @param string                                $type - item subtype to limit by 
     *
     * @return mixed
     */
    public function scopeForLoadout( Builder $query, string $term, string $type )
    {
        return $query->select(DB::raw('base_weapons.id as id, base_weapons.slug as slug, base_weapons.name as name, base_weapons.type as subtype, base_weapons.rarity, base_weapons.gear_score, null as weight_class, "Weapon" as type'))
            ->distinct()
            ->where('base_weapons.name', 'like', $term)
            // only for specific equipment slot
            ->where('base_weapons.type', '=', $type)
            // no test items
            ->where('name', 'not like', '@%')
        ;
    }
    
// -- MISC
    

}