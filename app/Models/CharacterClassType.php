<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CharacterClassType extends Model
{
    public function classes()
    {
        return $this->hasMany(CharacterClass::class, 'character_class_id');
    }
}