<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weapon extends Model
{
    public function type()
    {
        return $this->belongsTo(WeaponType::class);
    }
}