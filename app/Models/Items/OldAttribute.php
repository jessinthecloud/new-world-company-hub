<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

/** @deprecated */
class OldAttribute extends Model
{
    protected $table = 'attributes';
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
        return $this->belongsToMany(Weapon::class, 'attribute_weapon', 'weapon_id')->withPivot('amount');
    }
    
    public function armors()
    {
        return $this->belongsToMany(Armor::class, 'attribute_armor', 'armor_id')->withPivot('amount');
    }
}