<?php

namespace App\Http\Controllers\Items;

use App\Contracts\InventoryItemContract;
use App\Enums\ArmorType;
use App\Enums\Rarity;
use App\Enums\WeaponType;
use App\Enums\WeightClass;
use App\Http\Controllers\Controller;
use App\Models\Companies\Company;
use App\Models\Items\Perk;
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
                'owner' => $company,
                'ownerType' => 'company',
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