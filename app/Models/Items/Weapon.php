<?php

namespace App\Models\Items;

use App\Models\Characters\Character;
use App\Models\Characters\Loadout;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];
    
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
        return $this->belongsToMany(Perk::class);
    }
    
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('amount');
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function character()
    {
        return $this->belongsTo(Character::class);
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