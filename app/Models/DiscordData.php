<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscordData extends Model
{
    protected $table = 'discord_data';
    
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}