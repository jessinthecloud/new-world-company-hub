<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    public function weapons()
    {
        return $this->belongsToMany(Weapon::class)->withPivot('amount');
    }
    
    public function armor()
    {
        return $this->belongsToMany(Armor::class)->withPivot('amount');
    }
}