<?php

namespace App\Http\Controllers\Companies;

use App\Enums\ArmorType;
use App\Enums\AttributeType;
use App\Enums\ItemType;
use App\Enums\Rarity;
use App\Enums\WeaponType;
use App\Enums\WeightClass;
use App\GuildBank;
use App\Http\Controllers\Controller;
use App\Http\Requests\InventoryRequest;
use App\Models\Companies\Company;
use App\Models\Items\Perk;
use App\Services\ArmorService;
use App\Services\WeaponService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use function collect;
use function redirect;
use function route;
use function view;

class GuildBanksController extends Controller
{
    public function __construct(protected ArmorService $armorService, protected WeaponService $weaponService) 
    {
         
    }

    public function index(Request $request)
    {
        
    }

    /**
     * form to add items to bank
     * 
     * @param \App\GuildBank $guildBank
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create( GuildBank $guildBank )
    {
        return view(
            'dashboard.guild-bank.create-edit',
            [
                'base_armor_options' => $this->armorService->baseItemsOptions(),
                'base_weapon_options' => $this->weaponService->baseItemsOptions(),
                'armor_type_options' => $this->armorService->itemTypeOptions(),
                'weapon_type_options' => $this->weaponService->itemTypeOptions(),
                'perk_options' => $this->weaponService->perkOptions(),
                'rarity_options' => $this->weaponService->rarityOptions(),
                'tier_options' => $this->weaponService->tierOptions(),
                'weight_class_options' => $this->armorService->weightClassOptions(),
                'attribute_options' => $this->weaponService->attributeOptions(),
                'method' => 'POST',
                'form_action' => route('guild-banks.store', ['guildBank'=>$guildBank->slug]),
                'button_text' => 'Add Item',
            ]
        );
    } // end create()

    public function store( InventoryRequest $request, GuildBank $guildBank )
    {
        $validated = $request->validated();
        
        $service = (strtolower($validated['itemType']) == 'weapon') ? 'weaponService' : 'armorService';
        
        // get base item
        $base ??= $this->{$service}->baseItem($validated['base_id']);    
        $item = $this->{$service}->createItem( $validated, $base );
        $item = $this->{$service}->saveItemRelations(
            $validated, $item, $guildBank->company()->id, $base
        );
                
        return redirect(
            route('guild-banks.show',[
                'guildBank'=>$guildBank->slug
            ])
        )->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Inventory added successfully: '.($item->name)
            ]
        ]);    
    } // end store()

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\GuildBank           $guildBank
     * @param string|null              $itemType // Weapon/Armor/Material
     * @param string|null              $item     // slug of specific item
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit( Request $request, GuildBank $guildBank, string $itemType=null, string $item=null )
    {
        $itemSlug = $request->item;
        $itemType = $request->itemType;
       
        // get item specifics
        $model = 'App\Models\Items\\'.Str::title($itemType);
        $item = $model::with('perks','base','attributes')->where('slug', $itemSlug)->sole();

        $perks = Perk::orderBy('name')->distinct()->get()->mapWithKeys(function($perk){
            return [$perk->slug => $perk->name];
        });
        // existing perks
        $existing_perk_options = $this->weaponService->existingPerkOptions($item->perks->all(), $perks->sortBy('name')->all());

        // existing attributes
        [$existing_attribute_amounts, $existing_attribute_options] = 
            $this->weaponService->existingAttributeOptions(
                $item->attributes->all(), 
                collect(AttributeType::cases())->sortBy('value')->all()
            );

        return view(
            'dashboard.guild-bank.create-edit',
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
                'armor_type_options' => $this->armorService->itemTypeOptions($item->type),
                'weapon_type_options' => $this->weaponService->itemTypeOptions($item->type),
                'perk_options' => $this->weaponService->perkOptions($perks->sortBy('name')->all()),
                'rarity_options' => $this->weaponService->rarityOptions($item->rarity),
                'tier_options' => $this->weaponService->tierOptions($item->tier),
                'weight_class_options' => $this->armorService->weightClassOptions($item->weight_class ?? ''),
                'attribute_options' => $this->weaponService->attributeOptions(),
                'method' => 'PUT',
                'form_action' => route('guild-banks.update', ['guildBank'=>$guildBank->slug]),
                'button_text' => 'Edit Item',
            ]
        );
    }

    public function update( InventoryRequest $request, GuildBank $guildBank )
    {

        // Retrieve the validated input data...
        $validated = $request->validated();
    
        $model = 'App\Models\Items\\'.Str::title($validated['itemType']);
        $item = $model::where('id', '=', $validated['id'])->first();
        
        $service = (strtolower($validated['itemType']) == 'weapon') ? 'weaponService' : 'armorService';
        
        // update instanced item
        $base = $this->{$service}->baseItem($validated['base_id']) ?? $item->base;    
        $item = $this->{$service}->updateItem( $validated, $item, $base );
        $item = $this->{$service}->saveItemRelations(
            $validated, $item, $guildBank->company()->id, $base
        );
        
        return redirect(route('guild-banks.show',[
                'guildBank'=>$guildBank->slug
            ]))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Inventory edited successfully: '.($item->name)
            ]
        ]);    
    }
    
    public function choose(Request $request, $action=null )
    {

        $action = $request->action;
        
        if($action == 'edit-item-type'){

            // already chose guildBank
            $guildBank = $request->guildBank;
            $form_action = route('guild-banks.find', [
                'action'=>$action,
                'guildBank'=>$request->guildBank
            ]);
            
            $itemTypes = ItemType::toAssociative();

            return view(
                'dashboard.guild-bank.choose',
                compact('guildBank', 'action', 'form_action', 'itemTypes')
            );
        }
        
        if($action == 'edit-item'){
        
            // already chose guildBank and item type
            $guildBank = $request->guildBank;
            $itemType = $request->itemType;
            $form_action = route('guild-banks.find', [
                'action'=>$action,
                'guildBank'=>$request->guildBank
            ]);
            
            $model = 'App\Models\Items\\'.Str::title($itemType);

            $items = $model::whereRelation('company', 'slug', $guildBank?->slug ?? $guildBank)->get()->mapWithKeys(function($item){
                return [$item->slug => $item->name];
            })->all();

            return view(
                'dashboard.guild-bank.choose',
                compact('guildBank', 'action', 'form_action', 'itemType', 'items')
            );
        }
        
        if($request->action == 'destroy'){

            // already chose guildBank
            $company = Company::where('slug', $request->guildBank)->sole();
            $guildBank = new GuildBank($company);
            
            $method = 'DELETE';
            $form_action = route('guild-banks.destroy', [
                'action'=>$action,
                'guildBank'=>$request->guildBank,
            ]);
       
            $items = $guildBank->items()->mapWithKeys(function($item){
                // need to indicate type in case IDs collide
                return [strtolower($item->type).'-'.$item->id => $item->name];
            })->all();

            return view(
                'dashboard.guild-bank.choose',
                compact('guildBank', 'method', 'action', 'form_action', 'items')
            );
        }
        
        $guildBanks = Company::orderBy('name')->get()->mapWithKeys(function($guildBank){
            return [$guildBank->slug => $guildBank->name.' Guild Bank'];
        })->all();
        $form_action = route('guild-banks.find', ['action'=>$action]);

        return view(
            'dashboard.guild-bank.choose',
            compact('guildBanks', 'action', 'form_action')
        );
    }

    public function find(Request $request)
    {
        // if editing and already chose a company,send back to choose an item to edit
        if($request->action == 'edit' && empty($request->item)){
            return redirect(
                route('guild-banks.choose', [
                    'guildBank'=>$request->guildBank,
                    'action' => 'edit-item-type'
                ])
            );
        } 
        
        if($request->action == 'edit-item-type' && empty($request->item)){
            return redirect(
                route('guild-banks.choose', [
                    'guildBank'=>$request->guildBank,
                    'itemType'=>$request->itemType,
                    'action' => 'edit-item'
                ])
            );
        } 
        
        if($request->action == 'edit-item'){
            return redirect(
                route('guild-banks.edit', [
                    'guildBank'=>$request->guildBank,
                    'itemType'=>$request->itemType,
                    'item'=>$request->item,
                    'action' => 'edit'
                ])
            );
        } 
        
        return redirect(
            route('guild-banks.'.$request->action, [
                'guildBank'=>$request->guildBank->slug ?? $request->guildBank,
                'action' => $request->action,
            ])
        );
    }
    
    
    // if guildbank is not in URL, defaults to current logged-in user's selected company to create one 
    public function show(Request $request, GuildBank $guildBank=null)
    {
        if(!isset($guildBank?->company()->id)){
            $company = $request->user()->company();
            $guildBank = new GuildBank($company);
        }
        
        $company = $guildBank->company();

        $armors = ArmorType::valueToAssociative();
        $weapons = WeaponType::valueToAssociative();
        $weight_class = WeightClass::valueToAssociative();
        $rarity = Rarity::valueToAssociative();
        
        $perks = Perk::orderBy('name')->get()->mapWithKeys(function($perk){
            return [$perk->slug => $perk->name];
        });

        // add "Any" to the front of the filter arrays
        $armors = collect($armors)->prepend('Any', '')->all();
        $weapons = collect($weapons)->prepend('Any', '')->all();
        $weight_class = collect($weight_class)->prepend('Any', '')->all();
        $rarity = collect($rarity)->prepend('Any', '')->all();
        $perks = $perks->prepend('Any', '')->all();

        $types = [''=>'Any', 'Weapon'=>'Weapon', 'Armor'=>'Armor'];

        return view('guild-bank.show', 
            compact(
                'guildBank',
                'company',
                'armors',
                'weapons',
                'types',
                'weight_class',
                'rarity',
                'perks'
            )
        );
    }

    public function destroy( Request $request, GuildBank $guildBank )
    {
        // governor / (super-admin)        
        $item_id = is_int($request->item) ? $request->item : Str::afterLast($request->item, '-');
        $item_type = $request->itemType ?? Str::before($request->item, '-');
        $model = "App\Models\Items\\".Str::studly($item_type);
        $item = $model::find($item_id);
        $count = $model::destroy($item_id);
        
        if($count > 0){
            return redirect(route('guild-banks.show',[
                    'guildBank'=>$guildBank->slug
                ]))->with([
                'status'=> [
                    'type'=>'success',
                    'message' => 'Inventory deleted successfully: '.$item->name
                ]
            ]);
        }
        
        return redirect(
            route('guild-banks.show',[
                'guildBank'=>$guildBank->slug
            ]))->with([
            'status'=> [
                'type'=>'error',
                'message' => 'Inventory deletion failed for '.$item->name.' (ID: '.$item->id.')',
            ]
        ]);
    }
}
