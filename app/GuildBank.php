<?php

namespace App;

use App\Contracts\InventoryContract;
use App\Models\Companies\Company;
use App\Models\Items\Armor;
use App\Models\Items\Weapon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\Pure;
use Rappasoft\LaravelLivewireTables\DataTableComponent;

/**
 * Representation of the items tied directly to a company
 */
class GuildBank implements InventoryContract
{
    protected Builder $union_query;

    /**
     *
     * @param \App\Models\Companies\Company       $owner
     * @param \Illuminate\Support\Collection|null $items
     *      Reminder that constructor property promotion
     *      also declares and initializes the props
     */
    public function __construct( protected Company $owner, protected ?Collection $items=null )
    {
//        $this->items ??= $this->findItems();
    }

    /**
     * Livewire DataTable is ignoring mount(), so
     * allow it to create a GuildBank on demand
     * 
     * @param \App\Models\Companies\Company $company
     *
     * @return static
     */
    public static function make(Company $company) : self
    {
        return new self($company);
    }

    /**
     * Initialize the query for getting the bank's items from DB
     * 
     * @return \Illuminate\Database\Query\Builder
     */
    public function buildUnionQuery() : Builder
    {
        $union = Armor::rawForCompany($this->owner) 
            ->union(Weapon::rawForCompany($this->owner));
        // create derived table so that we can filter on the union as a whole if needed
        $this->union_query = DB::table(DB::raw("({$union->toSql()}) as items"))
            ->selectRaw('items.*');
        
        // manually attach bindings because mergeBindings() does not order them properly
        $bindings = $union->getBindings();
        $this->union_query->setBindings($bindings);
        
        return $this->union_query;
    }

    /**
     * Return the assembled Query
     * 
     * @return \Illuminate\Database\Query\Builder
     */
    public function unionQuery() : Builder
    {
        return $this->union_query ??= $this->buildUnionQuery();
    }

    /**
     * Query the database for the bank's items 
     * 
     * @return \Illuminate\Support\Collection
     */
    protected function findItems() : Collection
    {        
        return $this->items ??= $this->unionQuery()->get();
    }

    /**
     * Return all items in the bank
     * 
     * @return \Illuminate\Support\Collection
     */
    public function items() : Collection
    {
        return $this->items ??= $this->findItems();
    }

    /**
     * Initialize the query for getting the bank's items' perks from DB
     *
     * @param array                                   $bindings
     * @param array                                   $perks
     * @param \Illuminate\Database\Query\Builder|null $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function joinPerkQuery(Builder $query, array $bindings, array $perks=[]) : Builder
    {
        
        $query = $query->join('perk_weapon', function($join){
            return $join->on('items.id', '=', 'perk_weapon.weapon_id');
        }) 
            ->join('armor_perk', function($join){
                return $join->on('items.id', '=', 'armor_perk.armor_id');
            }) 
            ->join('perks', function($join) use ($perks) {
                return $join->on('perks.id', '=', 'perk_weapon.perk_id')
                    ->whereRaw('perks.slug IN 
                ('.implode(',', 
                    array_fill(0, count($perks), '?')).')')
                    ->orOn('perks.id', '=', 'armor_perk.perk_id') 
                    ->whereRaw('perks.slug IN 
                ('.implode(',', 
                    array_fill(0, count($perks), '?')).')')                   
                ;
            })
            ;
            
        $query = DB::table(DB::raw("({$query->toSql()}) as itemsWithPerks"))
            ->groupBy('id',
                      'name',
                      'subtype',
                      'type',
                      'rarity',
                      'gear_score',
                      'weight_class');
            
        // manually attach bindings because mergeBindings() does not order them properly
        $query->setBindings($bindings);
//ddd($query->toSql());        
        return $query;        
    }

    public function owner() : Model
    {
        return $this->owner;
    }

    public function company()
    {
        return $this->owner;
    }

    public function weapons()
    {
    }

    public function armor()
    {
    }

    public function materials()
    {
    }
}