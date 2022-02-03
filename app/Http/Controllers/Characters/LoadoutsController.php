<?php

namespace App\Http\Controllers\Characters;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoadoutUpsertRequest;
use App\Models\Characters\Character;
use App\Models\Characters\Loadout;
use App\Models\Items\BaseWeapon;
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
        return view(
            'dashboard.loadout.create-edit',
            [
                'equipment_slots' => [
                    'main' => [],
                    'offhand' => [],
                    'head' => [],
                    'chest' => [],
                    'legs' => [],
                    'feet' => [],
                    'hands' => [],
                    'neck' => [],
                    'ring' => [],
                    'earring' => [],
                    'shield' => [],
                ],
                'perk_options' => $this->weaponService->perkOptions(),
                'rarity_options' => $this->weaponService->rarityOptions(),
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
//dump($validated, $loadout, $loadout->weapons->pluck('pivot')->pluck('level')/*, $request*/);
        $loadout = Loadout::create([
            'name' => $validated['name'],
            'weight' => $validated['weight'],
            // relations
            'character_id' => $validated['character'],
            'main_hand_id' => $validated['main_hand'],
            'offhand_id' => $validated['offhand'],
        ]);
        
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