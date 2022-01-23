<?php

namespace App\Http\Livewire;

use App\Models\Items\BaseArmor;
use App\Models\Items\BaseWeapon;
use Livewire\Component;

class ItemDropDown extends Component
{

    // these are set and/or returned to the livewire component's view
    public $search = '';
    protected $search_results = [];
    
    // validation for the properties
    protected $rules = [
        'search' => 'required|string|min:3'
    ];
    
    // use mount() instead of a class constructor
    public function mount($search='')
    {
        $this->search = $search;
    }
    
    public function updatedSearch()
    {
        // don't make a request until we have 3 or more letters typed
        if (strlen($this->search) >= 3) {
            $this->validate();
            // $this->search_results = [['name'=>$this->search, 'type_name'=>'items', 'result_type'=>'items', 'slug'=>'nothing']];

            // replace spaces in terms with wildcard to allow forgiving searches
            $term = str_replace(' ', '%', $this->search);

            // do search request with livewire data from view
            /*$recipe_results = Recipe::where('name', 'like', '%'.$term.'%')
                ->orWhere('true_name', 'like', '%'.$term.'%')
                ->get();*/
            $raw_search_results = BaseArmor::rawForBankSearch('%'.$term.'%') 
                ->union(BaseWeapon::rawForBankSearch('%'.$term.'%'))
                ->orderBy('name')
                ->get();

            if (!empty($raw_search_results)) {
                // add table info so we know how to label and what routes to link
                $raw_search_results = $raw_search_results->map(function ($result) {
                    return collect($result)->merge([
                        'type' => $result->type,
                        'image_url' => $result->icon,
                    ]);
                });
                if ($raw_search_results->count() > 8) {
                    $this->search_results = $raw_search_results->take(8)->toArray();
                } else {
                    $this->search_results = $raw_search_results->toArray();
                }
            } else {
                $this->search_results = [];
            } // endif empty search result
        } else {
            $this->search_results = [];
        }
    }
    
    public function render()
    {
        return view( 'livewire.item-drop-down', [
            'search'=> $this->search,
            'search_results'=> $this->search_results,
        ]);
    }
}