<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuildBank extends Model
{
    protected $guarded = [];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];

    public function weapons()
    {
        return $this->belongsToMany(Weapon::class, 'weapon_inventory', 'guild_bank_id', 'weapon_id');
    }
    
    public function armor()
    {
        return $this->belongsToMany(Armor::class, 'armor_inventory', 'guild_bank_id', 'armor_id');
    }   

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}