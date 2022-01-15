<?php

namespace App\Models;

use App\Models\Characters\Character;
use App\Models\Characters\CharacterClassType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function classType()
    {
        return $this->belongsTo(CharacterClassType::class);
    }

    public function rosters()
    {
        return $this->belongsToMany(Roster::class);
    }
    
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}