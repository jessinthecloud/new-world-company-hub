<?php

namespace App\Models\Characters;

use Illuminate\Database\Eloquent\Model;

class SkillType extends Model
{
    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
    
// -- MISC
    public static function asArrayForDropDown()
    {
        return static::with(['skills' => function ($query) {
            $query->orderBy('order');
        }])->orderBy('order')->get()->all();
    }
}