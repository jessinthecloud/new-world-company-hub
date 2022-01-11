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
    protected $with = [];

    public function weapons()
    {
        return $this->morphedByMany(Weapon::class, 'item', 'guild_banks', 'item_id', 'company_id');
    }
    
    public function armor()
    {
        return $this->morphedByMany(Armor::class, 'item', 'guild_banks', 'item_id', 'company_id');
    }   

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}