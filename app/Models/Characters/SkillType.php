<?php

namespace App\Models\Characters;

use Illuminate\Database\Eloquent\Model;

class SkillType extends Model
{
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
}