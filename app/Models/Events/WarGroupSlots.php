<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

class WarGroupSlots extends Model
{
    public function warGroup()
    {
        return $this->belongsTo(WarBoardGroup::class);
    }
    
    public function warBoard()
    {
        return $this->hasOneThrough(WarBoard::class, WarBoardGroup::class);
    }
    
    public function slottable()
    {
        return $this->morphTo();
    }
}