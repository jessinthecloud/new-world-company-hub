<?php

namespace App\Models\Items;

use App\Models\Characters\Loadout;
use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/** @deprecated */
class OldInventoryItem extends Model
{
    protected $table = 'inventory_items';
    protected $guarded = ['id'];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['item'];
    
    public function ownerable(  )
    {
        return $this->morphTo();
    }

    public function item(  )
    {
        return $this->belongsTo(OldItem::class, 'item_id');
    }

    public function loadouts(  )
    {
        return $this->hasMany(Loadout::class);
    }
    
// -- SCOPES
    public function scopeOwnedBy( Builder $query, $owner )
    {
        return $query
            ->where('ownerable_type', $owner::class)
            ->where('ownerable_id', $owner->id)
        ;
    }
    public function scopeOwnedByCompany( Builder $query, Company $company )
    {
        return $query
            ->where('ownerable_type', $company::class)
            ->where('ownerable_id', $company->id)
        ;
    }
    public function scopeForTable( Builder $query )
    {
        return $query
//            ->selectRaw('armors.id as id, armors.slug as slug, armors.name as name, armors.type as subtype, armors.rarity, armors.gear_score, armors.weight_class, "Armor" as type, armors.created_at as created_at')
            ->with('item.itemable')
        ;
    }
}