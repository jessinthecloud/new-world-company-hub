<?php

namespace App\Models;

use App\Models\Characters\Character;
use App\Models\Characters\Loadout;
use App\Models\Companies\Company;
use App\Models\Companies\Rank;
use App\Models\Events\Event;
use App\Models\Events\Roster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are not mass assignable.
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

    public function loadouts(  )
    {
        return $this->hasManyThrough(Loadout::class, Character::class);
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
    
    public function companyInventory()
    {
        return $this->character()?->companyInventory();
    }

    public function company()
    {
        return $this->character()?->company;
    }
    
    public function faction()
    {
        return $this->character()?->company?->faction;
    }
    
    public function loadout()
    {
        return $this->character()?->loadout;
    }
    
// -- DISTANT RELATIONSHIPS

    /**
     * Would need custom hasManyThroughManyToMany() relation
     * https://stackoverflow.com/questions/37430217/has-many-through-many-to-many
     * 
     * @return mixed
     */
    public function factions()
    {
        return Faction::join('companies', 'companies.faction_id', '=', 'companies.id')
            ->join('characters', 'characters.company_id', '=', 'companies.id')
            ->join('users', 'users.id', '=', 'characters.user_id')
            ->where('users.id', '=', $this->id)->get()
        ;
//        return $this->hasManyThrough(Faction::class, Company::class, 'id', 'id', 'id');
    }

    /**
     * Would need custom hasManyThroughManyToMany() relation
     * https://stackoverflow.com/questions/37430217/has-many-through-many-to-many
     * 
     * @return mixed
     */
    public function companies()
    {
        return Company::join('characters', 'characters.company_id', '=', 'companies.id')
            ->join('users', 'users.id', '=', 'characters.user_id')
            ->where('users.id', '=', $this->id)->get();
//        return $this->hasManyThrough(Company::class, Character::class);
    }
    
    /**
     * Would need custom hasManyThroughManyToMany() relation
     * https://stackoverflow.com/questions/37430217/has-many-through-many-to-many
     * 
     * @return mixed
     */
    public function ranks()
    {
        return Rank::join('characters', 'characters.rank_id', '=', 'ranks.id')
            ->join('users', 'users.id', '=', 'characters.user_id')
            ->where('users.id', '=', $this->id)->get();
//        return $this->hasManyThrough(Rank::class, Character::class);
    }
    
    public function rosters()
    {
        return Roster::join('companies', 'rosters.company_id', '=', 'companies.id')
            ->join('characters', 'characters.company_id', '=', 'companies.id')
            ->join('users', 'users.id', '=', 'characters.user_id')
            ->where('users.id', '=', $this->id)->get();
//        return $this->hasManyThrough(Roster::class, Character::class);
    }
    
    public function events()
    {
        return $this->hasManyThrough(Event::class, Character::class);
    } 
    
// -- SCOPES
    public function scopeFindSuperAdmin( $query )
    {
        return $query->where('slug', config('app.super_admin'));
    }
    
// -- MISC
    public function isSuperAdmin()
    {
        return $this->slug == config('app.super_admin');
    }
}
