<?php

namespace App\Models\Events;

use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function type()
    {
        return $this->belongsTo(EventType::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function roster()
    {
        return $this->hasOne(Roster::class);
    }
    
    public function warPlans()
    {
        return $this->hasMany(WarPlan::class);
    }

    public function warBoards()
    {
        return $this->hasMany(WarBoard::class);
    }
}