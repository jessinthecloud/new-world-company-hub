<?php

namespace App\Models\Companies;

use App\Models\Characters\Character;
use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    public function character()
    {
        return $this->hasMany(Character::class);
    }
    
    public static function asArrayForDropDown()
    {
        return static::distinct()
            ->get()
            ->mapWithKeys(function($model){
                return [$model->id => $model->name];
            })
            ->all();
    }
}