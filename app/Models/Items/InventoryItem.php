<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model
{
    public function ownable(  )
    {
        return $this->morphTo();
    }
}