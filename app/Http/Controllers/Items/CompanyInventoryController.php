<?php

namespace App\Http\Controllers\Items;

use App\Enums\ArmorType;
use App\Enums\Rarity;
use App\Enums\WeaponType;
use App\Enums\WeightClass;
use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Models\CompanyInventory;
use App\Models\Items\Perk;
use App\Services\ItemService;

class CompanyInventoryController extends Controller
{
    public function __construct(protected ItemService $itemService) { }

    public function index(Company $company)
    {           
        // info for display filters
        $armors = ArmorType::valueToAssociative();
        $weapons = WeaponType::valueToAssociative();
        $weight_class = WeightClass::valueToAssociative();
        $rarity = Rarity::valueToAssociative();
        $perks = Perk::asArrayForDropDown();

        // add "Any" to the front of the filter arrays
        $armors = collect($armors)->prepend('Any', '')->all();
        $weapons = collect($weapons)->prepend('Any', '')->all();
        $weight_class = collect($weight_class)->prepend('Any', '')->all();
        $rarity = collect($rarity)->prepend('Any', '')->all();
        $perks = collect($perks)->prepend('Any', '')->all();
        // item types
        $types = [''=>'Any', 'Weapon'=>'Weapon', 'Armor'=>'Armor'];

        return view('inventory.index', 
            [
                'inventory' => $company,
                'armors' => $armors,
                'weapons' => $weapons,
                'types' => $types,
                'weight_class' => $weight_class,
                'rarity' => $rarity,
                'perks' => $perks,
            ]
        );
    }
    
    /**
     * form to add items to bank
     *
     * @param \App\Models\Companies\Company $company
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create( Company $company )
    {
        return view(
            'dashboard.inventory.create-edit',
            [
                'base_options' => $this->itemService->baseItemsOptions(),
                'perk_options' => $this->itemService->perkOptions(),
                'rarity_options' => $this->itemService->rarityOptions(),
                'method' => 'POST',
                'form_action' => route('companies.inventory.store', ['company'=>$company->slug]),
                'button_text' => 'Add Item',
            ]
        );
    } // end create()
}