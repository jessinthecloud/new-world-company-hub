<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
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

    public function weapons()
    {
        return $this->belongsToMany(Weapon::class)->withPivot('amount');
    }
    
    public function armor()
    {
        return $this->belongsToMany(Armor::class)->withPivot('amount');
    }
}