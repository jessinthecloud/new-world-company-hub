<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];
    
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
    
    public function faction()
    {
        return $this->belongsTo(Faction::class);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function events()
    {
        $this->hasMany(Event::class);
    }
    
    public function weapons()
    {
        return $this->morphedByMany(Weapon::class, 'item', 'guild_banks', 'company_id', 'item_id');
    }
    
    public function armor()
    {
        return $this->morphedByMany(Armor::class, 'item', 'guild_banks', 'company_id', 'item_id');
    }
    
    public function bank()
    {
        return $this->hasOne(GuildBank::class)->withDefault('amount');
    }
}