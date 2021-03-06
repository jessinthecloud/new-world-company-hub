<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function positions()
    {
        return $this->belongsToMany(Position::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}