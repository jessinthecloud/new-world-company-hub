<?php

namespace App\Models\Characters;

use App\Models\Companies\Company;
use App\Models\GearCheck;
use App\Models\Items\OldBaseWeapon;
use App\Models\Items\OldInventoryItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loadout extends Model
{
    use HasFactory;
    
    protected $guarded=['id'];
    
    protected $with = ['gearCheck'];
    
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
    
    /*public function user()
    {
        return $this->hasOneThrough(User::class, Character::class);
    }*/

    public function company(  )
    {
        return $this->hasOneThrough(Company::class, Character::class);
    }

    public function main()
    {
        return $this->belongsTo(OldInventoryItem::class, 'main_hand_id');
    }

    public function offhand()
    {
        return $this->belongsTo(OldInventoryItem::class, 'offhand_id');
    }
    
    public function helmet()
    {
        return $this->belongsTo(OldInventoryItem::class, 'head_id');
    }

    public function head(  )
    {
        return $this->helmet();
    }
    
    public function chest()
    {
        return $this->belongsTo(OldInventoryItem::class, 'chest_id');
    }
    
    public function legs()
    {
        return $this->belongsTo(OldInventoryItem::class, 'legs_id');
    }
    public function pants()
    {
        return $this->belongsTo(OldInventoryItem::class, 'legs_id');
    }
    
    public function feet()
    {
        return $this->belongsTo(OldInventoryItem::class, 'feet_id');
    }
        public function shoes()
        {
            return $this->belongsTo(OldInventoryItem::class, 'feet_id');
        }
        public function boots()
        {
            return $this->belongsTo(OldInventoryItem::class, 'feet_id');
        }
    
    public function hands()
    {
        return $this->belongsTo(OldInventoryItem::class, 'hands_id');
    }
        public function gloves(  )
        {
            return $this->belongsTo(OldInventoryItem::class, 'hands_id');
        }
    
    public function neck()
    {
        return $this->belongsTo(OldInventoryItem::class, 'neck_id');
    }
        public function amulet(  )
        {
            return $this->belongsTo(OldInventoryItem::class, 'neck_id');
        }
    
    public function ring()
    {
        return $this->belongsTo(OldInventoryItem::class, 'ring_id');
    }
    public function earring()
    {
        return $this->belongsTo(OldInventoryItem::class, 'earring_id');
    }
    public function shield()
    {
        return $this->belongsTo(OldInventoryItem::class, 'shield_id');
    }

    public function gearCheck(  )
    {
        return $this->hasOne(GearCheck::class);
    }

    public function approved(  )
    {
        return isset($this->gearCheck);
    }
    
// -- SCOPES 

// -- MISC
    public static function asArrayForDropDown()
    {
        return static::with('character','main','offhand')
        ->orderBy('name')
        ->orderBy('weight')
        ->get()
        ->mapWithKeys(function($loadout){
            return [
                $loadout->id => $loadout->name ?? ''
                    . ' (Main: '.$loadout->main->name
                    .' -- Offhand: '.$loadout->off?->name.')'
            ];
        })->all();
    }
}