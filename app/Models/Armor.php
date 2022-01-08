<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armor extends Model
{
    public function base()
    {
        return $this->hasOne(BaseArmor::class);
    }
    
    public function sets()
    {
        return $this->belongsToMany(ArmorSet::class);
    }
    
    public function perks()
    {
        return $this->belongsToMany(Perk::class)->withPivot('amount');
    }
    
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('amount');
    }
    
    public function bank()
    {
        return $this->morphTo(GuildBank::class, 'bankable')->withPivot('amount');
    }
}