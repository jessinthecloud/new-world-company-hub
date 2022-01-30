<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['id'];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['itemable'];

    public function itemable(  )
    {
        return $this->morphTo();
    }

    public function inventory(  )
    {
        return $this->hasOne(InventoryItem::class);
    }
}