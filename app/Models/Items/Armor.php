<?php

namespace App\Models\Items;

use App\Models\Characters\Character;
use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Armor extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];

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
        return $this->belongsToMany(Perk::class);
    }
    
    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'attribute_armor')->withPivot('amount');
    }
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}