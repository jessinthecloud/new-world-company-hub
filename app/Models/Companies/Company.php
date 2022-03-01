<?php

namespace App\Models\Companies;

use App\CompanyInventory;
use App\Models\Characters\Character;
use App\Models\Characters\Loadout;
use App\Models\Events\Event;
use App\Models\Events\WarBoard;
use App\Models\Events\WarPlan;
use App\Models\Faction;
use App\Models\Items\OldInventoryItem;
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
     * Assign the site super admin as a team super admin
     * whenever a new company is created
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // here assign this team to a global user with global default role
        self::created(function ($model) {
           // get session team_id for restore it later
           $session_team_id = getPermissionsTeamId();
           // set actual new team_id to package instance
           setPermissionsTeamId($model);
           // get the admin user and assign roles/permissions on new team model
           User::findSuperAdmin()->assignRole('super-admin');
           // restore session team_id to package instance
           setPermissionsTeamId($session_team_id);
        });
    }
    
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
        return $this->hasMany(Event::class);
    }
    
    public function warPlans()
    {
        return $this->hasMany(WarPlan::class);
    }
    
    public function warBoards()
    {
        return $this->hasMany(WarBoard::class);
    }
    
    public function loadouts()
    {
        return $this->hasManyThrough(Loadout::class, Character::class);
    }
    
    /*public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }
    
    public function armor()
    {
        return $this->hasMany(Armor::class);
    }*/

    public function inventoryItem(  )
    {
        return $this->morphMany(OldInventoryItem::class, 'ownerable');
    }

    public function inventory()
    {
        return new CompanyInventory($this->attributes);
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
    
    /** @method withMembers() */
    public function scopeWithMembers( Builder $query )
    {
        return $query->with('characters')
            ->whereRelation('characters', 'company_id', '=', $this->id)
            ->orderBy('name')
        ;
    }
    
// -- MISC
    public static function asArrayForDropDown()
    {
        return static::with('faction')
            ->orderBy('name')
            ->get()
            ->mapWithKeys(function($company){
            return [
                $company->slug => $company->name . ' ('.$company->faction->name.')'
            ];
        })->all();
    }

    public function members()
    {
        return $this->characters;
    }
}