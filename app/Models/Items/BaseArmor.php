<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

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
}