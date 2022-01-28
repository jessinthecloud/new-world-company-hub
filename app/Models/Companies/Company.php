<?php

namespace App\Models\Companies;

use App\GuildBank;
use App\Models\Characters\Character;
use App\Models\Faction;
use App\Models\Items\Armor;
use App\Models\Items\Weapon;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    /*protected static function boot()
    {
        parent::boot();
        
        // here assign this team to a global user with global default role
        self::created(function ($model) {
            // get session team_id for restore it later
            $session_team_id = getPermissionsTeamId();
            // set actual new team_id to package instance
            setPermissionsTeamId($model);
            // get the admin user and assign roles/permissions on new team model
            User::role('super-admin')->get()->assignRole('super-admin');
            // restore session team_id to package instance
            setPermissionsTeamId($session_team_id);
        });
    }*/
    
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
    
    /**
     * Would need custom hasManyThroughManyToMany() relation
     * https://stackoverflow.com/questions/37430217/has-many-through-many-to-many
     * 
     * @return mixed
     *
    public function users(  )
    {
        return $this->hasManyThrough(User::class, Character::class);
    }
    //*/

    public function scopeForUser( Builder $query, $user_id )
    {
        return $query->with('faction')
            ->where('user_id', '=', $user_id)
            ->orderBy('name')
        ;
    }
}