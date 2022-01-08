<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseArmor extends Model
{
    public function instances()
    {
        return $this->hasMany(Armor::class);
    }
}