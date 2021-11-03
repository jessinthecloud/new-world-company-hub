<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loadout extends Model
{
    use HasFactory;
    
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function main()
    {
        return $this->belongsTo(Weapon::class, 'main_hand_id');
    }

    public function offhand()
    {
        return $this->belongsTo(Weapon::class, 'offhand_id');
    }
}