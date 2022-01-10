<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armor extends Model
{
    protected $guarded = ['id'];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['base', 'perks','attributes'];

    public function base()
    {
        return $this->belongsTo(BaseArmor::class);
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
        return $this->belongsToMany(Attribute::class, 'attribute_armor')->withPivot('amount');
    }
    
    public function banks()
    {
        return $this->belongsToMany(GuildBank::class, 'armor_inventory');
    }
}