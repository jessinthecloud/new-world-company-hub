<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BaseArmor extends Model
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['perks'];
    
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
        return $this->hasMany(Armor::class);
    }
    
    public function sets()
    {
        return $this->belongsToMany(ArmorSet::class);
    }
    
    public function perks()
    {
        return $this->belongsToMany(Perk::class)->withPivot('chance');
    }

    public function iconUrl()
    {
        // image that exists: primordial-void-gauntlet-1-t5 (weapon)
//    dump(storage_path('app/images/'.Str::afterLast(strtolower($this->icon), '/')));
        Storage::url('app/images/'.Str::afterLast(strtolower($this->icon), '/'));
    }
}