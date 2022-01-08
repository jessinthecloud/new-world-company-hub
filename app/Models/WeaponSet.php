<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeaponSet extends Model
{
    public function weapons()
    {
        return $this->belongsToMany(Weapon::class);
    }
}