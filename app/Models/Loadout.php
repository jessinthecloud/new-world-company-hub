<?php

namespace App\Models;

use App\Models\Items\BaseWeapon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loadout extends Model
{
    use HasFactory;
    
    protected $guarded=[];
    
    public function character()
    {
        return $this->belongsTo(Character::class);
    }

    public function main()
    {
        return $this->belongsTo( BaseWeapon::class, 'main_hand_id');
    }

    public function offhand()
    {
        return $this->belongsTo( BaseWeapon::class, 'offhand_id');
    }
}