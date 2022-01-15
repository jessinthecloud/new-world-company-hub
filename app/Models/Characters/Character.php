<?php

namespace App\Models\Characters;

use App\Models\Company;
use App\Models\Faction;
use App\Models\Items\Armor;
use App\Models\Items\Weapon;
use App\Models\Position;
use App\Models\Rank;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['company', 'rank'];
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
// -- RELATIONSHIPS

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function rank()
    {
        return $this->belongsTo(Rank::class);
    }

    public function class()
    {
        return $this->belongsTo(CharacterClass::class, 'character_class_id');
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class)->withPivot('level');
    }

    public function loadout()
    {
        return $this->hasOne(Loadout::class);
    }

    public function positions()
    {
        return $this->hasMany(Position::class);
    }
    
    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }
    
    public function armor()
    {
        return $this->hasMany(Armor::class);
    }
    
// -- DISTANT RELATIONSHIPS

    public function faction()
    {
        // hasOneThrough() was not working
        return $this->hasOneThrough(Faction::class, Company::class);
    }    
}