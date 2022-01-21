<?php

namespace App\Models\Items;

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



// -- MISC


}