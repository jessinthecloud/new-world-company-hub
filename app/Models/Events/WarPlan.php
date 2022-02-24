<?php

namespace App\Models\Events;

use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Model;

class WarPlan extends Model
{
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}