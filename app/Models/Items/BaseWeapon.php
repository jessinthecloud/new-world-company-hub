<?php

namespace App\Models\Items;

use App\Models\Characters\Loadout;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class BaseWeapon extends BaseItem
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
    
// -- MISC
    

}