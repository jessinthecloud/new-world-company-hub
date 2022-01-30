<?php

namespace App\Http\Controllers\Items;

use App\Contracts\InventoryItemContract;
use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Services\ArmorService;
use App\Services\WeaponService;
use Illuminate\Http\Request;

class CompanyInventoryController extends Controller
{
    public function __construct(protected ArmorService $armorService, protected WeaponService $weaponService) 
    {
         
    }
    
    public function index(Company $company)
    {
        dump('inventory will be here');
    }

    /**
     * form to add items to bank
     * 
     * @param \App\GuildBank $guildBank
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create( Company $company )
    {
        return view(
            'dashboard.inventory.create-edit',
            [
                'base_armor_options' => $this->armorService->baseItemsOptions(),
                'base_weapon_options' => $this->weaponService->baseItemsOptions(),
                'armor_type_options' => $this->armorService->itemTypeOptions('Armor'),
                'weapon_type_options' => $this->weaponService->itemTypeOptions('Weapon'),
                'perk_options' => $this->weaponService->perkOptions(),
                'rarity_options' => $this->weaponService->rarityOptions(),
                'tier_options' => $this->weaponService->tierOptions(),
                'weight_class_options' => $this->armorService->weightClassOptions(),
                'attribute_options' => $this->weaponService->attributeOptions(),
                'method' => 'POST',
                'form_action' => route('companies.inventory.store', ['company'=>$company->slug]),
                'button_text' => 'Add Item',
            ]
        );
    } // end create()

    public function store( Request $request )
    {
        //
    }

    public function show( Company $company )
    {
        //
    }

    public function edit( Company $company, string $type, InventoryItemContract $item )
    {
        //
    }

    public function update( Request $request, Company $company, string $type, InventoryItemContract $item )
    {
        //
    }

    public function destroy( Company $company, string $type, InventoryItemContract $item )
    {
        //
    }
}