<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    public function ownerable(  )
    {
        return $this->morphTo();
    }

    public function item(  )
    {
        return $this->belongsTo(Item::class);
    }
}