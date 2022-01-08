<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArmorSet extends Model
{
    public function armor()
    {
        return $this->belongsToMany(Armor::class);
    }
}