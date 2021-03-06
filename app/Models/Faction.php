<?php

namespace App\Models;

use App\Models\Companies\Company;
use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    protected $guarded=[];
    
    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = [];
    
    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
    
// -- MISC
    public static function asArrayForDropDown()
    {
        return static::orderBy('name')
            ->get()
            ->mapWithKeys(function($faction){
            return [$faction->slug => $faction->name];
        })->all();
    }
}