<?php

namespace App\Models\Items;

use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
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
        return $this->belongsTo(Item::class);
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
}