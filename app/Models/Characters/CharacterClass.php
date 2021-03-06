<?php

namespace App\Models\Characters;

use App\Models\Events\WarGroupSlots;
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
    
    public function warGroupSlots()
    {
        return $this->morphMany(WarGroupSlots::class, 'slottable');
    }
    
    public static function asArrayForDropDown()
    {
        return static::distinct('name')->get()
            ->mapWithKeys(function($model){
                return [$model->id => $model->name];
            })
            ->all();
    }
}