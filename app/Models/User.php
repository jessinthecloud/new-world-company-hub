<?php

namespace App\Models;

use App\Models\Characters\Character;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];

// -- RELATIONSHIPS

    public function characters()
    {
        return $this->hasMany(Character::class);
    }

    public function discord()
    {
        return $this->hasOne( DiscordData::class);
    }
    
// -- MISC - NOT relationships

    /**
     * Get the current primary character that we are logged in with
     *
     * @return \App\Models\Characters\Character|null
     */
    public function character() : ?Character
    {
        return session('character') ?? null;
    }
    
    public function rank()
    {
        return $this->character()?->rank;
    }

    public function company()
    {
        return $this->character()?->company;
    }
    
    public function faction()
    {
        return $this->character()?->company?->faction;
    }
    
// -- DISTANT RELATIONSHIPS

    /*
    public function factions()
    {
        return $this->hasManyThrough(Faction::class, Company::class);
    }
    
    public function companies()
    {
        return $this->hasManyThrough(Company::class, Character::class, 'user_id', 'company_id', 'id');
    }
    
    public function ranks()
    {
        return $this->hasManyThrough(Rank::class, Character::class);
    }
    
    public function rosters()
    {
        return $this->hasManyThrough(Roster::class, Character::class);
    }
    
    public function events()
    {
        return $this->hasManyThrough(Event::class, Character::class);
    } 
    */
}
