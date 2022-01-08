<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseArmor extends Model
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

    public function instances()
    {
        return $this->hasMany(Armor::class);
    }
}