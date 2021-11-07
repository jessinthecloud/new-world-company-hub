<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}