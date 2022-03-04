<?php

namespace App\Models;

use App\Models\Characters\Character;
use App\Models\Companies\Company;
use App\Models\Items\Item;
use Illuminate\Database\Eloquent\Model;

class CompanyInventory extends Model
{
    protected $guarded = ['id'];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['company', 'item'];
    
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
    
    public function banker()
    {
        return $this->belongsTo(Character::class, 'banker_id');
    }
}