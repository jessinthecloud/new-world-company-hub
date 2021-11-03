<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterClass extends Model
{
    public function type()
    {
        return $this->belongsTo(ClassType::class);
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}