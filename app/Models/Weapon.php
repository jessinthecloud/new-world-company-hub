<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    protected $guarded = ['id'];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['base', 'perks','attributes'];
    
    public function base()
    {
        return $this->belongsTo(BaseWeapon::class);
    }
    
    public function sets()
    {
        return $this->belongsToMany(WeaponSet::class);
    }
    
    public function perks()
    {
        return $this->belongsToMany(Perk::class)->withPivot('amount');
    }
    
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('amount');
    }
    
    public function banks()
    {
        return $this->belongsToMany(GuildBank::class, 'weapon_inventory', 'weapon_id', 'guild_bank_id');
    }

    public function mainLoadout()
    {
        return $this->hasMany(Loadout::class, 'main_hand_id');
    }

    public function offhandLoadout()
    {
        return $this->hasMany(Loadout::class, 'offhand_id');
    }
}