<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseWeapon extends Model
{
    use HasFactory;
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    public function instances()
    {
        return $this->hasMany(Weapon::class);
    }
    
    public function sets()
    {
        return $this->belongsToMany(WeaponSet::class);
    }
    
    public function perks()
    {
        return $this->belongsToMany(Perk::class)->withPivot('amount');
    }
    
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('amount');
    }

    public function mainLoadout()
    {
        return $this->hasMany(Loadout::class, 'main_hand_id');
    }

    public function offhandLoadout()
    {
        return $this->hasMany(Loadout::class, 'offhand_id');
    }
}