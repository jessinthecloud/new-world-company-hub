<?php

namespace App\Models\Items;

use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Item extends Model
{
    protected $guarded = ['id'];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['type', 'subtype'];
    
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
    public function base()
    {
        return $this->belongsTo(BaseItem::class);
    }
    
    public function type()
    {
        return $this->hasOneThrough(ItemType::class, BaseItem::class);
    }
    
    public function subtype()
    {
        return $this->belongsTo(ItemSubtype::class);
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
    
    public function suffix()
    {
        return $this->hasOneThrough(Suffix::class, Perk::class);
    }
    
    public function prefix()
    {
        return $this->hasOneThrough(Prefix::class, Perk::class);
    }
    
    public function perks()
    {
        return $this->belongsToMany(Perk::class);
    }
    
    public function owner()
    {
        // todo: implement
    }
    
// -- SCOPES
    public function scopeRawForCompany($query, Company $company)
    {
        /*return $this->select(DB::raw('weapons.id as id, weapons.slug as slug, weapons.name as name, weapons.type as itemable_type, weapons.rarity, weapons.gear_score, null as weight_class, "Weapon" as type, weapons.created_at as created_at'))
            ->whereRelation('company', 'id', $company->id);*/
    }
    
    public function scopeRawForGearScore($query/*, Item $item*/)
    {
        return $this->select(DB::raw('id,gear_score'));
    }
    
    public function scopeSimilarSlugs(Builder $query, string $slug){
        return $query->where('slug', 'like' , $slug.'%');
    }
    
    public function numberOfUnusedPerkSlots()
    {
        // todo: implement
    }
}