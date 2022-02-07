<?php

namespace App\Http\Controllers\Characters;

use App\Enums\ArmorType;
use App\Enums\AttributeType;
use App\Enums\Rarity;
use App\Enums\WeaponType;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadoutUpsertRequest;
use App\Models\Characters\Character;
use App\Models\Characters\Loadout;
use App\Models\Items\BaseWeapon;
use App\Models\Items\Perk;
use App\Services\ArmorService;
use App\Services\WeaponService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

use function dump;
use function redirect;
use function route;
use function view;

class LoadoutsController extends Controller
{
    public function __construct(
        protected ArmorService $armorService, 
        protected WeaponService $weaponService
    ) 
    {
         
    }
    
    public function index()
    {
        $loadouts = Loadout::asArrayForDropDown();
        
        dump($loadouts);
    }
    
    public function choose()
    {
        $loadouts = Loadout::asArrayForDropDown();
        $form_action = route('loadouts.find');

        return view(
            'dashboard.loadout.choose',
            compact('loadouts', 'form_action')
        );
    }

    public function find(Request $request)
    {
//    ddd($request);
        return redirect(route('loadouts.'.$request->action, ['loadout'=>$request->loadout]));
    }

    /**
     * Show Loadout create form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : View
    {
        $equipment_slots = [
            'main' => [
                'type' => 'weapon',
                'subtype'=>null,
                'required' => true,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
            'offhand' => [
                'type' => 'weapon',
                'subtype'=>null,
                'required' => true,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
            'head' => [
                'type' => 'armor',
                'subtype'=>ArmorType::from('Helmet')->name,
                'required' => true,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
            'chest' => [
                'type' => 'armor',
                'subtype'=>ArmorType::from('Chest')->name,
                'required' => true,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
            'legs' => [
                'type' => 'armor',
                'subtype'=>ArmorType::from('Pants')->name,
                'required' => true,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
            'feet' => [
                'type' => 'armor',
                'subtype'=>ArmorType::from('Shoes')->name,
                'required' => true,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
            'hands' => [
                'type' => 'armor',
                'subtype'=>ArmorType::from('Gloves')->name,
                'required' => true,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
            'neck' => [
                'type' => 'armor',
                'subtype'=>ArmorType::from('Amulet')->name,
                'required' => true,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
            'ring' => [
                'type' => 'armor',
                'subtype'=>ArmorType::from('Ring')->name,
                'required' => true,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
            'earring' => [
                'type' => 'armor',
                'subtype'=>ArmorType::from('Earring')->name,
                'required' => true,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
            'shield' => [
                'type' => 'weapon',
                'subtype'=>WeaponType::Shield->value,
                'required' => false,
                'fields' => [
                    'tier' => null,
                    'rarity' => null,
                    'perks' => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name' => null,
                ],
            ],
        ];
        // on failed submission
        if(!empty(old())){
//dump(request()->old());
            // loop equip types
            foreach($equipment_slots as $name => $info) {
                // get old values
//dump(request()->old(), $name, old('perks')[$name]);                
                // existing perks
                $equipment_slots[$name]['existing_perk_options'] = $this->weaponService->existingPerkOptions(
                    array_filter(old('perks')[$name]),
                    Perk::asArrayForDropDown(),
                );
                
                // existing attributes
                [$existing_attribute_amounts, $existing_attribute_options] = 
                $this->weaponService->existingAttributeOptions(
                    array_filter(old('attrs')[$name]),
                    collect(AttributeType::cases())->sortBy('value')->all(),
                    array_filter(old('attribute_amounts')[$name]),
                );
                $equipment_slots[$name]['existing_attribute_options'] = $existing_attribute_options;
                $equipment_slots[$name]['existing_attribute_amounts'] = $existing_attribute_amounts;
            }
        }
    
        return view(
            'dashboard.loadout.create-edit',
            [
                'equipment_slots' => $equipment_slots,
                'perk_options' => $this->weaponService->perkOptions(),
                'raritys' => Rarity::valueToAssociative(),
                'tier_options' => $this->weaponService->tierOptions(),
                'weight_class_options' => $this->armorService->weightClassOptions(),
                'attribute_options' => $this->weaponService->attributeOptions(),
                'method' => 'POST',
                'form_action' => route('loadouts.store'),
                'button_text' => 'Add',
            ]
        );
    }

    public function store( LoadoutUpsertRequest $request )
    {
        $validated = $request->validated();

dump($request->all(), $validated, '=========');
        $inventory = [];
        // loop slot names to create items
        foreach($validated['equipment_slot_names'] as $equipment_slot){
            
            $itemType = $validated['itemType'][$equipment_slot];
            $gear_score = $validated['gear_score'][$equipment_slot];
            $rarity = $validated['rarity'][$equipment_slot];
            $perks = $validated['perks'][$equipment_slot];
            $attribute_amounts = $validated['attribute_amounts'][$equipment_slot];
            $attrs = $validated['attrs'][$equipment_slot];
            $base_id = $validated['base_id'][$equipment_slot];
            $base_slug = $validated['base_slug'][$equipment_slot];
            $id = $validated['id'][$equipment_slot];
            $slug = $validated['slug'][$equipment_slot];
            
            $values = [
                'itemType' => $itemType,
                'gear_score' => $gear_score,
                'rarity' => $rarity,
                'perks' => $perks,
                'attribute_amounts' => $attribute_amounts,
                'attrs' => $attrs,
                'base_id' => $base_id,
                'base_slug' => $base_slug,
                'id' => $id,
                'tier' => null,
                'slug' => $slug,
            ];
dump('VALUES',$values);
            $service = (strtolower($itemType) == 'weapon') ? 'weaponService' : 'armorService';// get base item
            $base = $this->{$service}->baseItem($base_id);
            $values [strtolower($itemType).'_type']= $base->type;
            $specificItem = $this->{$service}->createSpecificItem( $values, $base );
            $specificItem = $this->{$service}->saveSpecificItemRelations(
                $values, $specificItem, $base
            );
            $morphableItem = $this->{$service}->createMorphableItem($specificItem);
            $inventory[$equipment_slot]= $this->{$service}->createInventoryItem($morphableItem, request()->user()->character());
    //        dd($inventoryItem);
            dump($equipment_slot, $inventory[$equipment_slot]);
        }
        $loadout = Loadout::create([
               'weight' => $weight ?? null,
               'gear_score' => $validated['gear_score']['character'],
               // relations
               'character_id' => request()->user()->character()->id,
               'main_hand_id' => $inventory['main']->id,
               'offhand_id' => $inventory['offhand']->id,
               'head_id' => $inventory['head']->id,
               'chest_id' => $inventory['chest']->id,
               'legs_id' => $inventory['legs']->id,
               'feet_id' => $inventory['feet']->id,
               'hands_id' => $inventory['hands']->id,
               'neck_id' => $inventory['neck']->id,
               'ring_id' => $inventory['ring']->id,
               'earring_id' => $inventory['earring']->id,
               'shield_id' => $inventory['shield']->id,
           ]);
           dump($loadout);
        die;


        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Loadout created successfully'
            ]
        ]);
    }

    public function show( Loadout $loadout )
    {
        //
    }

    /**
     * Loadout edit form
     *
     * @param \App\Models\Characters\Loadout $loadout
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit( Loadout $loadout )
    {
        $characters = Character::with('class')->orderBy('name')->get()->mapWithKeys(function($class){
            return [$class->id => $class->name];
        })->all();

        $loadout = $loadout->load('main', 'offhand', 'character');

        $weapons = BaseWeapon::orderBy( 'name')->get()->mapWithKeys(function($weapon){
            return [$weapon->id => $weapon->name.' ('.$weapon->type->name.')'];
        })->all();

        $character_options = '';
        foreach($characters as $value => $text) {
            $character_options .= '<option value="'.$value.'"';
            if($loadout->character->id === $value){
                $character_options .= ' SELECTED ';
            }
            $character_options .= '>'.$text.'</option>';
        }

        $main_options = '';
        foreach($weapons as $value => $text) {
            $main_options .= '<option value="'.$value.'"';
            if($loadout->main->id === $value){
                $main_options .= ' SELECTED ';
            }
            $main_options .= '>'.$text.'</option>';
        }

        $offhand_options = '';
        foreach($weapons as $value => $text) {
            $offhand_options .= '<option value="'.$value.'"';
            if($loadout->offhand->id === $value){
                $offhand_options .= ' SELECTED ';
            }
            $offhand_options .= '>'.$text.'</option>';
        }

        return view(
        'dashboard.loadout.create-edit',
        [
            'loadout' => $loadout,
            'character_options' => $character_options,
            'main_options' => $main_options,
            'offhand_options' => $offhand_options,
            'method' => 'PUT',
            'form_action' => route('loadouts.update', ['loadout'=>$loadout]),
            'button_text' => 'Edit',
        ]
        );
    }

    public function update( LoadoutUpsertRequest $request, Loadout $loadout )
    {
        $validated = $request->validated();
//dump($validated, $loadout, $loadout->weapons->pluck('pivot')->pluck('level')/*, $request*/);
        $loadout->name = $validated['name'];
        $loadout->weight = $validated['weight'];
        // relations
        $loadout->character()->associate($validated['character']);
        $loadout->main()->associate($validated['main']);
        $loadout->offhand()->associate($validated['offhand']);
        $loadout->save();
        
//        dump($loadout, $loadout->weapons->pluck('pivot')->pluck('level'));
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Loadout updated successfully'
            ]
        ]);
    }

    public function destroy( Loadout $loadout )
    {
        Loadout::destroy($loadout);

        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Loadout deleted successfully'
            ]
        ]);
    }
}