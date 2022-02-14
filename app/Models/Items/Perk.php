<?php

namespace App\Models\Items;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Perk extends Model
{
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

    public function weapons()
    {
        return $this->belongsToMany(Weapon::class)->withPivot('amount');
    }
    
    public function armors()
    {
        return $this->belongsToMany(Armor::class)->withPivot('amount');
    }
    
    public function baseWeapons()
    {
        return $this->belongsToMany(BaseWeapon::class,)->withPivot('amount');
    }
    
    public function baseArmor()
    {
        return $this->belongsToMany(BaseArmor::class)->withPivot('amount');
    }
// -- SCOPES
    
    /** @method forSearch() */
    public function scopeForSearch( Builder $query, string $term )
    {
        return $query->where('name', 'like', $term);
    }
    
    public function scopeForItemDropdown($query){
        return $query->whereNotIn('perk_type', ['Gem', 'Inherent'])->orderBy('name');
    }
    
// -- MISC
    public static function asArrayForDropDown() : array
    {
        return Perk::forItemDropdown()->get()->mapWithKeys(function($perk){
            return [$perk->slug => $perk->name];
        })->all();
    }
    
    public static function selectOptions(array $models=null, array $selected=[]) : string
    {
        $models ??= static::asArrayForDropDown();
        
        $options = '<option value=""></option>'."\n";
        foreach($models as $value => $text) {
//            $options .= '<option value="'.$value.'">'.$text.'</option>';
            $options .= '<option value="'.$value.'"';
                if(in_array($value, $selected)){
                    $options .= ' SELECTED ';
                }
            $options .= '>'.$text.'</option>'."\n";
        }
        return $options;
    }
}