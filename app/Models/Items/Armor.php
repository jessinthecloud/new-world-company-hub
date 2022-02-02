<?php

namespace App\Models\Items;

use App\CompanyInventory;
use App\Contracts\InventoryItemContract;
use App\Models\Characters\Character;
use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Armor extends Model implements InventoryItemContract
{
    use HasFactory;

    protected $guarded = ['id'];
    
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

    public function base()
    {
        return $this->belongsTo(BaseArmor::class);
    }
    
    public function sets()
    {
        return $this->belongsToMany(ArmorSet::class);
    }
    
    public function perks()
    {
        return $this->belongsToMany(Perk::class);
    }
    
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_armor')->withPivot('amount');
    }
    
    public function company()
    {
        return $this->asItem()->inventory()->where('ownerable_type', Company::class)->ownerable;
    }
    
    public function character()
    {
        return $this->asItem()->inventory()->where('ownerable_type', Character::class)->ownerable;
    }

    public function asItem(  )
    {
        return $this->morphOne(Item::class, 'itemable');
    }
    
    /**
     * @return mixed
     */
    public function owner() : mixed
    {
        return $this->asItem->inventory->ownerable;
    }
    
    /**
     * @return mixed
     */
    public function ownerInventory() : mixed
    {
        $type = "\\App\\".Str::afterLast($this->asItem->inventory->ownerable_type,'\\').'Inventory';
        
        return $type::find($this->asItem->inventory->ownerable->id);
    }
    
// SCOPES ---
    public function scopeRawForCompany($query, Company $company)
    {
        return $this->select(DB::raw('armors.id as id, armors.slug as slug, armors.name as name, armors.type as subtype, armors.rarity, armors.gear_score, armors.weight_class, "Armor" as type, armors.created_at as created_at'))
            ->whereRelation('company', 'id', $company->id);
    }
    
    public function scopeRawForInventory($query, InventoryItem $inventoryItem)
    {
        return $this->select(DB::raw('armors.id as id, armors.slug as slug, armors.name as name, armors.type as subtype, armors.rarity, armors.gear_score, armors.weight_class, "Armor" as type, armors.created_at as created_at'))
            ->whereRelation('company', 'id', $inventoryItem->id);
    }
    
    public function scopeRawForGearScore($query/*, Item $item*/)
    {
        return $this->select(DB::raw('id, gear_score'))
//            ->whereRelation('asItem', 'id', $item->id)
            ;
    }
    
    public function scopeSimilarSlugs(Builder $query, string $slug){
        return $query->where('slug', 'like' , $slug.'%');
    }

}