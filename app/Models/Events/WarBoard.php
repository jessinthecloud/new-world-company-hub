<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

class WarBoard extends Model
{
    public function event()
    {
        return $this->hasOne(Event::class);
    }

    public function groups()
    {
        return $this->hasMany(WarBoardGroup::class);
    }

    public function plan()
    {
        // todo: implement
    }
}