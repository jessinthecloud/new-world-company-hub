<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeaponType extends Model
{
    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
    
    public function weapons()
    {
        return $this->hasMany(Weapon::class);
    }
}