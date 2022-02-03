<?php

namespace App\Models\Characters;

use App\Models\Companies\Company;
use App\Models\Items\BaseWeapon;
use App\Models\Items\InventoryItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loadout extends Model
{
    use HasFactory;
    
    protected $guarded=[];
    
    public function character()
    {
        return $this->belongsTo(Character::class);
    }
    
    public function user()
    {
        return $this->hasOneThrough(User::class, Character::class);
    }

    public function company(  )
    {
        return $this->hasOneThrough(Company::class, Character::class);
    }

    public function main()
    {
        return $this->belongsTo( InventoryItem::class, 'main_hand_id');
    }

    public function offhand()
    {
        return $this->belongsTo( InventoryItem::class, 'offhand_id');
    }
    
    public function helmet()
    {
        return $this->belongsTo( InventoryItem::class, 'head_id');
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