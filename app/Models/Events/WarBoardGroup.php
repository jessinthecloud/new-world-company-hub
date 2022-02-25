<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

class WarBoardGroup extends Model
{
    public function warBoard()
    {
        return $this->belongsTo(WarBoard::class);
    }
    
    public function slots()
    {
        return $this->hasMany(WarGroupSlots::class);
    }
}