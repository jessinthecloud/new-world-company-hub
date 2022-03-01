<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

class OldAttribute extends Model
{
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['weapons', 'armors'];
    
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
        return $this->belongsToMany(OldWeapon::class)->withPivot('amount');
    }
    
    public function armors()
    {
        return $this->belongsToMany(OldArmor::class, 'attribute_armor')->withPivot('amount');
    }
}