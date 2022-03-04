<?php

namespace App\Models;

use App\Models\Characters\Character;
use App\Models\Items\Item;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CharacterInventory extends Model
{
    protected $table = 'character_inventory';

    protected $guarded = ['id'];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['character', 'item'];
    
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}