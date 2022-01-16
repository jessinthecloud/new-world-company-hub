<?php

namespace App\Models\Items;

use App\Models\Characters\Loadout;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        return $this->belongsToMany(Perk::class)->withPivot('chance');
    }
    
    public function mainLoadout()
    {
        return $this->hasMany(Loadout::class, 'main_hand_id');
    }

    public function offhandLoadout()
    {
        return $this->hasMany(Loadout::class, 'offhand_id');
    }
    
    public function iconUrl()
    {
        // image that exists: primordial-void-gauntlet-1-t5 (weapon)
//    dump(storage_path('app/images/'.Str::afterLast(strtolower($this->icon), '/')));
        Storage::url('app/images/'.Str::afterLast(strtolower($this->icon), '/'));
    }
}