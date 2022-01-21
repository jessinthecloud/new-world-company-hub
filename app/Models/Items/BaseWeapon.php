<?php

namespace App\Models\Items;

use App\Models\Characters\Loadout;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    
// -- MISC
    

}