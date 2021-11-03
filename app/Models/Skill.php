<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    public function type()
    {
        return $this->belongsTo(SkillType::class);
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class);
    }
}