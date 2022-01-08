<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuildBank extends Model
{
    protected $guarded = [];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['company'];

    public function bankable()
    {
        return $this->morphTo()->withPivot('amount');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}