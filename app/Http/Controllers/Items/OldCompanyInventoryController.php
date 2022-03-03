<?php

namespace App\Http\Controllers\Items;

use App\OldCompanyInventory;
use App\Contracts\InventoryItemContract;
use App\Enums\ArmorType;
use App\Enums\AttributeType;
use App\Enums\Rarity;
use App\Enums\WeaponType;
use App\Enums\WeightClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryUpsertRequest;
use App\Models\Companies\Company;
use App\Models\Items\Armor;
use App\Models\Items\OldInventoryItem;
use App\Models\Items\OldPerk;
use App\Models\Items\Weapon;
use App\Services\ArmorService;
use App\Services\WeaponService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/** @deprecated */
class OldCompanyInventoryController extends Controller
{
    public function __construct(protected ArmorService $armorService, protected WeaponService $weaponService) 
    {
         
    }

    public function convertAll()
    {
        $company = Company::where('slug', 'breakpoint')->first();
        $weapons = Weapon::all();
        foreach($weapons as $weapon) {
            if(is_null($weapon->asItem)) {
                $this->convert( $company, 'Weapon', $weapon );
            }
        }
        $armors = Armor::all();
        foreach($armors as $armor) {
            if(is_null($armor->asItem)){
                $this->convert($company, 'Armor', $armor);
            }
        }
        
        return redirect(
            route('companies.inventory.index',[
                'company'=>$company->slug
            ])
        )->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Inventory items converted successfully.'
            ]
        ]);
    }
    
    protected function convert(Company $company, string $type, InventoryItemContract $item)
    {
        if(!is_null($item->asItem)) {
            return;
        }
        $service = (strtolower($type) == 'weapon') ? 'weaponService' : 'armorService';
        $morphableItem = $this->{$service}->createMorphableItem($item);
        $inventoryItem = $this->{$service}->createInventoryItem($morphableItem, $company);        
    }
    
    
    public function index(OldCompanyInventory $company)
    {
        $companyInventory = $company;
        $company = Company::find($companyInventory->id);
        
        $armors = ArmorType::valueToAssociative();
        $weapons = WeaponType::valueToAssociative();
        $weight_class = WeightClass::valueToAssociative();
        $rarity = Rarity::valueToAssociative();
        $perks = OldPerk::asArrayForDropDown();

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
                'inventory' => $companyInventory,
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
     * @param \App\Models\Companies\Company $company
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

    public function store( InventoryUpsertRequest $request, Company $company )
    {
        $validated = $request->validated();
        
        $service = (strtolower($validated['itemType']) == 'weapon') ? 'weaponService' : 'armorService';
        
        // get base item
        $base ??= $this->{$service}->baseItem($validated['base_id']);
        $specificItem = $this->{$service}->createSpecificItem( $validated, $base );
        $specificItem = $this->{$service}->saveSpecificItemRelations(
            $validated, $specificItem, $base
        );
        $morphableItem = $this->{$service}->createMorphableItem($specificItem);
        $inventoryItem = $this->{$service}->createInventoryItem($morphableItem, $company);
//        dd($inventoryItem);
        return redirect(
            route('companies.inventory.index',[
                'company'=>$company->slug
            ])
        )->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Inventory added successfully: '.($specificItem->name)
            ]
        ]);
    }

    public function edit( Company $company, OldInventoryItem $inventoryItem )
    {
//        dump($inventoryItem);
        
        // get item specifics
        $item = $inventoryItem->item->itemable;
        $itemType = Str::afterLast($item::class, '\\');
        
        $perks = OldPerk::orderBy('name')->distinct()->get()->mapWithKeys(function($perk){
            return [$perk->slug => $perk->name];
        });
        // existing perks
        $existing_perk_options = $this->weaponService->existingPerkOptions($item->perks->all(), $perks->sortBy('name')->all());

        // existing attributes
        [$existing_attribute_amounts, $existing_attribute_options] = 
            $this->weaponService->existingAttributeOptions(
                $item->itemAttributes->all(), 
                collect(AttributeType::cases())->sortBy('value')->all()
            );
            
        return view(
            'dashboard.inventory.create-edit',
            [
                'existing_perk_options'=>$existing_perk_options,
                'existing_attribute_options'=>$existing_attribute_options,
                'existing_attribute_amounts'=>$existing_attribute_amounts,
                'item' => $item,
                'itemType' => $itemType,
                'isWeapon' => strtolower($itemType) == 'weapon' ? 1 : 0,
                'isArmor' => strtolower($itemType) == 'armor' ? 1 : 0,
                'newEntry' => isset($item?->base?->id) ? 0 : 1,
                'base_armor_options' => $this->armorService->baseItemsOptions($item),
                'base_weapon_options' => $this->weaponService->baseItemsOptions($item),
                'armor_type_options' => $this->armorService->itemTypeOptions($itemType),
                'weapon_type_options' => $this->weaponService->itemTypeOptions($itemType),
                'perk_options' => $this->weaponService->perkOptions($perks->sortBy('name')->all()),
                'rarity_options' => $this->weaponService->rarityOptions($item->rarity),
                'tier_options' => $this->weaponService->tierOptions($item->tier),
                'weight_class_options' => $this->armorService->weightClassOptions($item->weight_class ?? ''),
                'attribute_options' => $this->weaponService->attributeOptions(),
                'method' => 'PUT',
                'form_action' => route('companies.inventory.update', [
                    'company'=>$company->slug,
                    'inventoryItem'=>$inventoryItem->id,
                ]),
                'button_text' => 'Edit Item',
            ]
        );
    }

    public function update( InventoryUpsertRequest $request, Company $company, OldInventoryItem $inventoryItem )
    {
        // get item specifics
        $specificItem = $inventoryItem->item->itemable;
        $specificItemType = Str::afterLast($specificItem::class, '\\');
        
        $service = (strtolower($specificItemType) == 'weapon') ? 'weaponService' : 'armorService';
        
        // Retrieve the validated input data...
        $validated = $request->validated();
        
        // update instanced item
        // get base item
        $base ??= $this->{$service}->baseItem($validated['base_id']);
        $specificItem = $this->{$service}->updateSpecificItem( $validated, $specificItem, $base );
        $specificItem = $this->{$service}->saveSpecificItemRelations(
            $validated, $specificItem, $base
        );
        $morphableItem = $this->{$service}->updateMorphableItem($specificItem);
        $inventoryItem = $this->{$service}->updateInventoryItem($morphableItem, $company);

        return redirect(
            route('companies.inventory.index',[
                'company'=>$company->slug
            ])
        )->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Inventory edited successfully: '.($specificItem->name)
            ]
        ]);
    }

    public function destroy( Company $company, OldInventoryItem $inventoryItem )
    {
        $specificItem = $inventoryItem->item->itemable;
        
        // delete specific item
        if(!$specificItem->delete()){
            return redirect(
                route('companies.inventory.index',[
                    'company'=>$company->slug
                ])
            )->with([
                'status'=> [
                    'type'=>'error',
                    'message' => 'Inventory deletion failed for '.$specificItem->name.' (ID: '.$specificItem->id.')',
                ]
            ]);
        }
        // delete item
        if(!$inventoryItem->item->delete()){
            return redirect(
                route('companies.inventory.index',[
                    'company'=>$company->slug
                ])
            )->with([
                'status'=> [
                    'type'=>'error',
                    'message' => 'Inventory deletion failed for Item '.$inventoryItem->item->id,
                ]
            ]);
        }
        // delete inventory item
        if(!$inventoryItem->delete()){
            return redirect(
                route('companies.inventory.index',[
                    'company'=>$company->slug
                ])
            )->with([
                'status'=> [
                    'type'=>'error',
                    'message' => 'Inventory deletion failed for Inventory Item '.$inventoryItem->id,
                ]
            ]);
        }
        
        return redirect(
            route('companies.inventory.index',[
                'company'=>$company->slug
            ])
        )->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Inventory deleted successfully: '.($specificItem->name)
            ]
        ]);
    }
}