<?php

namespace App;

use App\Contracts\InventoryContract;
use App\Models\Characters\Character;
use App\Models\Companies\Company;
use App\Models\Items\Armor;
use App\Models\Items\Weapon;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Representation of the items tied directly to a company
 */
class GuildBank implements InventoryContract
{
    protected Builder $union_query;
    public string $slug;

    /**
     *
     * @param \App\Models\Companies\Company|\App\Models\Characters\Character $owner (Company or Character)
     * @param \Illuminate\Support\Collection|null                            $items
     *                                                                              Reminder that constructor property promotion
     *                                                                              also declares and initializes the props
     */
    public function __construct( protected Company | Character $owner, protected ?Collection $items=null )
    {
        $this->slug = $this->owner->slug;
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

    public function owner() : Company | Character
    {
        return $this->owner;
    }

    public function company() : ?Company
    {
        return ($this->owner instanceof Company) ? $this->owner : null;
    }
    
    public function character() : ?Character
    {
        return ($this->owner instanceof Character) ? $this->owner : null;
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