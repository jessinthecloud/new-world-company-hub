<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuildBank extends Model
{
    public function bankable()
    {
        return $this->morphTo()->withPivot('amount');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}