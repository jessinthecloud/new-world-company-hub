<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Model;

class OldItem extends Model
{
    protected $guarded = ['id'];
    
    protected $table = 'old_items';
    
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
        return $this->hasOne(OldInventoryItem::class, 'item_id');
    }
}