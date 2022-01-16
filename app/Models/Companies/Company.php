<?php

namespace App\Models\Companies;

use App\GuildBank;
use App\Models\Characters\Character;
use App\Models\Faction;
use App\Models\Items\Armor;
use App\Models\Items\Weapon;
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
        return $this->hasMany(Weapon::class);
    }
    
    public function armor()
    {
        return $this->hasMany(Armor::class);
    }

    public function bank()
    {
        return new GuildBank($this);
    }

}