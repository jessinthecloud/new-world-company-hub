<?php

namespace App\Models\Characters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    
    public function type()
    {
        return $this->belongsTo(SkillType::class, 'skill_type_id');
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class)->withPivot('level');
    }
}