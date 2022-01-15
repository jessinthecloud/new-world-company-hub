<?php

namespace App\Models\Characters;

use Illuminate\Database\Eloquent\Model;

class CharacterClass extends Model
{
    public function type()
    {
        return $this->belongsTo(CharacterClassType::class, 'character_class_type_id');
    }

    public function characters()
    {
        return $this->hasMany(Character::class);
    }
}