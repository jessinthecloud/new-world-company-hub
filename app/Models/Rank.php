<?php

namespace App\Models;

use App\Models\Characters\Character;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    public function character()
    {
        return $this->hasMany(Character::class);
    }
}