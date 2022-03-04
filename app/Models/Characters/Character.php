<?php

namespace App\Models\Characters;

use App\Models\CharacterInventory;
use App\Models\Companies\Company;
use App\Models\Companies\Rank;
use App\Models\CompanyInventory;
use App\Models\Events\Position;
use App\Models\Events\WarGroupSlots;
use App\Models\Faction;
use App\Models\ItemOwner;
use App\Models\Items\Item;
use App\Models\Items\OldInventoryItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model implements ItemOwner
{
    use HasFactory;
    
    protected $guarded = [];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['company', 'rank', 'loadout'];
    
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
    
    public function items()
    {
        return $this->hasManythrough(Item::class, CharacterInventory::class);
    }

    public function bankInventory()
    {
        return $this->hasManyThrough(Item::class, CompanyInventory::class);
    }
    
    /*public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }
    
    public function armor()
    {
        return $this->hasMany(Armor::class);
    }*/
    
    /** @deprecated */
    public function inventoryItem(  )
    {
        return $this->morphMany(OldInventoryItem::class, 'ownerable');
    }
    
    /**
     * @return mixed
     */
    public function inventory()
    {
        // TODO: Implement inventory() method.
    }
    
    public function warGroupSlots()
    {
        return $this->morphMany(WarGroupSlots::class, 'slottable');
    }

    public static function asArrayForDropDown()
    {
        return static::forDropDown()
            ->get()
            ->mapWithKeys(function($character){
                return [$character->slug => $character->name 
                    .( $character->level > 0 ? ' (Level '.$character->level.') ' : '') 
                    . $character->class->name
                ];
            })
            ->all();
    }
    
// -- DISTANT RELATIONSHIPS

    public function faction()
    {
        // hasOneThrough() was not working
        return $this->hasOneThrough(Faction::class, Company::class);
    }
    
// -- SCOPES

    public function scopeForUser( Builder $query, $user_id )
    {
        return $query->where('user_id', '=', $user_id)
            ->orderBy('name')
            ->orderBy('level');
    }

    public function scopeForDropDown( $query )
    {
        return $query->with('class')
            ->orderBy('name')
            ->orderBy('level');
    }
}