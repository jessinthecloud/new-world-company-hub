<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

class Suffix extends Model
{
    protected $guarded = ['id'];
    
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
    
    public function items()
    {
        return $this->hasManyThrough(Item::class, Perk::class);
    }
}