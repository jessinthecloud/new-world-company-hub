<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Services\ItemService;

class CompanyInventoryController extends Controller
{
    public function __construct(protected ItemService $itemService) { }

    public function index()
    {
        //
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
                'tier_options' => $this->itemService->tierOptions(),
                'weight_class_options' => $this->itemService->weightClassOptions(),
                'attribute_options' => $this->itemService->attributeOptions(),
                'method' => 'POST',
                'form_action' => route('companies.inventory.store', ['company'=>$company->slug]),
                'button_text' => 'Add Item',
            ]
        );
    } // end create()
}