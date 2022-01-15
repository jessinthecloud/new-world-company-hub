<?php

namespace App\Models\Companies;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    public function events()
    {
        $this->hasMany(Event::class);
    }
}