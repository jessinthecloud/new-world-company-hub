<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function faction()
    {
        return $this->belongsTo(Faction::class);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}