<?php

namespace App\Models;

use App\Models\Characters\Character;
use App\Models\Characters\Loadout;
use Illuminate\Database\Eloquent\Model;

class GearCheck extends Model
{
    public function loadout(  )
    {
        $this->belongsToMany(Loadout::class);
    }
    
    public function approver(  )
    {
        $this->belongsToMany(Character::class, 'approver_id');
    }
}