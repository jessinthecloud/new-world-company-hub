<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BaseItem extends Model
{
    use HasFactory;
    
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

// -- RELATIONSHIPS

    public function instances()
    {
        return $this->hasMany(Item::class);
    }

    public function perks()
    {
        return $this->belongsToMany(Perk::class);
    }
    
    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }
    
    public function rarity()
    {
        // TODO: implement
        // return $this->belongsTo(Rarity::class);
    }

// -- SCOPES
    
    /** @method bankable() */
    public function scopeBankable(Builder $query)
    {
        return $this
            ->where('named', 0)
            ->where('bindOnPickup', 0)
            // no test items
            ->where('name', 'not like', '@%')
            // no items under tier 5
            ->where('tier', '>=', 5)
            ;
    }
    
    /** @method rawForBankSearch() */
    public function scopeRawForBankSearch( Builder $query, string $term )
    {
        return $this->select(DB::raw('base_items.id as id, base_items.slug as slug, base_items.name as name, base_items.type as subtype, base_items.rarity, base_items.gear_score, null as weight_class, "Weapon" as type'))
            ->where('base_items.name', 'like', $term)
            ->where('named', 0)
            ->where('bindOnPickup', 0)
            // no test items
            ->where('name', 'not like', '@%')
            // no items under tier 5
            ->where('tier', '>=', 5)
        ;
    }
    
    /** @method rawForSearch() */
    public function scopeRawForSearch( Builder $query, string $term )
    {
        return $query->select(DB::raw('base_items.id as id, base_items.slug as slug, base_items.name as name, base_items.type as subtype, base_items.rarity, base_items.gear_score, null as weight_class, "Weapon" as type'))
            ->distinct()
            ->where('base_items.name', 'like', $term)
            // no test items
            ->where('name', 'not like', '@%')
        ;
    }
    
    /**
     * @method rawForLoadout()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $term - to search for
     * @param string                                $type - item subtype to limit by 
     *
     * @return mixed
     */
    public function scopeRawForLoadout( Builder $query, string $term, string $type )
    {
        return $query->select(DB::raw('base_items.id as id, base_items.slug as slug, base_items.name as name, base_items.type as subtype, base_items.rarity, base_items.gear_score, null as weight_class, "Weapon" as type'))
            ->distinct()
            ->where('base_items.name', 'like', $term)
            // only for specific equipment slot
            ->where('type', '=', $type)
            // no test items
            ->where('name', 'not like', '@%')
        ;
    }
    
    /**
     * @method forLoadout()
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string                                $term - to search for
     * @param string                                $type - item subtype to limit by 
     *
     * @return mixed
     */
    public function scopeForLoadout( Builder $query, string $term, string $type )
    {
        return $query->select(DB::raw('base_items.id as id, base_items.slug as slug, base_items.name as name, base_items.subtype_id as subtype, base_items.rarity, base_items.gear_score, null as weight_class, base_items.type_id as type'))
            ->distinct()
            ->where('base_items.name', 'like', $term)
            // only for specific equipment slot
            ->where('base_items.type', '=', $type)
            // no test items
            ->where('name', 'not like', '@%')
        ;
    }
    
// -- MISC
    
    public function iconUrl()
    {
        // image that exists: primordial-void-gauntlet-1-t5 (weapon)
//    dump(storage_path('app/images/'.Str::afterLast(strtolower($this->icon), '/')));
        Storage::url('app/images/'.Str::afterLast(strtolower($this->icon), '/'));
    }
}