<?php

namespace App\Models\Events;

use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Model;

class WarBoard extends Model
{
    public function event()
    {
        return $this->hasOne(Event::class);
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class);
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