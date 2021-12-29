<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    protected $guarded=[];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}