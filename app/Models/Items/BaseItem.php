<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class BaseItem extends Model
{

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

// -- RELATIONSHIPS

    abstract public function instances();

    public function perks()
    {
        return $this->belongsToMany(Perk::class)->withPivot('chance');
    }

// -- SCOPES

    public function scopeBankable(Builder $query)
    {
        return $this->where('named', 0)->where('bindOnPickup', 0);
    }
    
// -- MISC
    
    public function iconUrl()
    {
        // image that exists: primordial-void-gauntlet-1-t5 (weapon)
//    dump(storage_path('app/images/'.Str::afterLast(strtolower($this->icon), '/')));
        Storage::url('app/images/'.Str::afterLast(strtolower($this->icon), '/'));
    }
}