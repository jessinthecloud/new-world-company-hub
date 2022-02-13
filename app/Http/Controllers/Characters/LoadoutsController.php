<?php

namespace App\Http\Controllers\Characters;

use App\Enums\AttributeType;
use App\Enums\GearCheckThreshold;
use App\Enums\Rarity;
use App\Exceptions\MissingLoadoutSlotException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadoutUpsertRequest;
use App\Models\Characters\Character;
use App\Models\Characters\Loadout;
use App\Models\Items\BaseWeapon;
use App\Models\Items\Perk;
use App\Providers\RouteServiceProvider;
use App\Services\ArmorService;
use App\Services\LoadoutService;
use App\Services\WeaponService;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

use function dump;
use function redirect;
use function route;
use function view;

class LoadoutsController extends Controller
{
    /**
     * @var array[]
     */
    private array $equipmentSlots;

    public function __construct(
        protected ArmorService $armorService,
        protected WeaponService $weaponService,
        protected LoadoutService $loadoutService,
    ) {
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
        return redirect(route('loadouts.' . $request->action, ['loadout' => $request->loadout]));
    }

    /**
     * Show Loadout create form
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request) : View
    {
        if ( !empty($request->old()) ) {
            // on failed submission
            // populate the old form data
            $this->loadoutService->populateDropdowns($this->weaponService, $request->old());
        }

        return view(
            'dashboard.loadout.create-edit',
            [
                'equipment_slots'      => $this->loadoutService->equipmentSlots,
                'perk_options'         => $this->weaponService->perkOptions(),
                'raritys'              => Rarity::valueToAssociative(),
                'tier_options'         => $this->weaponService->tierOptions(),
                'weight_class_options' => $this->armorService->weightClassOptions(),
                'attribute_options'    => $this->weaponService->attributeOptions(),
                'method'               => 'POST',
                'form_action'          => route('loadouts.store', [
                    'login' => $request->query('login')
                ]),
                'button_text'          => 'Add',
            ]
        );
    }

    public function store(LoadoutUpsertRequest $request)
    {
        $validated = $request->validated();
        try {
            $inventory = $this->loadoutService->updateOrCreateItemsForSlots(
                $validated,
                $request->user()->character()
            );
        } catch ( ModelNotFoundException $e ) {
            Log::warning('Loadout creation failed: ' . $e->getMessage());

            return redirect()->back()->with([
                'status' => [
                    'type'    => 'error',
                    'message' => 'Loadout creation failed. Please try again.',
                ],
            ])
                ->withInput();
        }

        $loadout = Loadout::create([
           'weight'       => $weight ?? null,
           'gear_score'   => $validated['gear_score']['character'],
           // relations
           'character_id' => request()->user()->character()->id,
           'main_hand_id' => $inventory['main']->id,
           'offhand_id'   => $inventory['offhand']->id,
           'head_id'      => $inventory['head']->id,
           'chest_id'     => $inventory['chest']->id,
           'legs_id'      => $inventory['legs']->id,
           'feet_id'      => $inventory['feet']->id,
           'hands_id'     => $inventory['hands']->id,
           'neck_id'      => $inventory['neck']->id,
           'ring_id'      => $inventory['ring']->id,
           'earring_id'   => $inventory['earring']->id,
           'shield_id'    => isset($inventory['shield']) ? $inventory['shield']->id : null,
       ]);

        // todo: fire Event?

        if ( $request->query('login') ) {
            return redirect(RouteServiceProvider::DASHBOARD)->with([
               'status' => [
                   'type'    => 'success',
                   'message' => 'Loadout created successfully',
               ],
           ]);
        }

        return redirect(route('dashboard'))->with([
              'status' => [
                  'type'    => 'success',
                  'message' => 'Loadout created successfully',
              ],
          ]);
    }

    public function show(Loadout $loadout)
    {
        $owner = $loadout->main->item->itemable->owner();
        $ownerType = Str::afterLast(strtolower($owner::class), '\\');
        $character_name = Str::title($loadout->character->name);
        $gear_score = $loadout->gear_score;
        $loadout_check = GearCheckThreshold::passes($gear_score);
        $inventory = $loadout->main->item->itemable->ownerInventory();

        [$weapon_slot, $armor_slot, $jewelry_slot] = $this->loadoutService->populateEquipmentSlotGroups($loadout);

        return view('loadouts.show', [
            'loadout'        => $loadout,
            'loadout_check'  => $loadout_check,
            'gear_score'     => $gear_score,
            'character_name' => $character_name,
            'owner'          => $owner,
            'ownerType'      => $ownerType,
            'inventory'      => $inventory,
            'jewelry_slot'   => $jewelry_slot,
            'armor_slot'     => $armor_slot,
            'weapon_slot'    => $weapon_slot,
        ]);
    }

    /**
     * Loadout edit form
     *
     * @param \Illuminate\Http\Request       $request
     * @param \App\Models\Characters\Loadout $loadout
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Request $request, Loadout $loadout)
    {
        // on failed submission
        // get from 
        $values = empty($request->old())
            ? $this->loadoutService->getDropdownValuesFromLoadout($loadout)
            : $request->old();

        // populate the old form data
        $this->loadoutService->populateDropdowns($this->weaponService, $values);

        return view(
            'dashboard.loadout.create-edit',
            [
                'loadout'              => $loadout,
                'equipment_slots'      => $this->loadoutService->equipmentSlots,
                'perk_options'         => $this->weaponService->perkOptions(),
                'raritys'              => Rarity::valueToAssociative(),
                'tier_options'         => $this->weaponService->tierOptions(),
                'weight_class_options' => $this->armorService->weightClassOptions(),
                'attribute_options'    => $this->weaponService->attributeOptions(),
                'method'               => 'PUT',
                'form_action'          => route('loadouts.update', ['loadout' => $loadout]),
                'button_text'          => 'Edit',
            ]
        );
    }

    public function update(LoadoutUpsertRequest $request, Loadout $loadout)
    {
        $validated = $request->validated();
        
        $originalLoadout = new Loadout($loadout->getAttributes());
    
        try {
            $inventory = $this->loadoutService->updateOrCreateItemsForSlots(
                $validated,
                $request->user()->character(),
                $loadout
            );
        } catch ( ModelNotFoundException $e ) {
            Log::warning('Loadout edit failed: ' . $e->getMessage());

            return redirect()->back()->with([
                'status' => [
                    'type'    => 'error',
                    'message' => 'Loadout edit failed. Please try again.',
                ],
            ])
                ->withInput();
        }

        $loadout->update([
             'weight'       => $weight ?? null,
             'gear_score'   => $validated['gear_score']['character'],
             'main_hand_id' => $inventory['main']->id,
             'offhand_id'   => $inventory['offhand']->id,
             'head_id'      => $inventory['head']->id,
             'chest_id'     => $inventory['chest']->id,
             'legs_id'      => $inventory['legs']->id,
             'feet_id'      => $inventory['feet']->id,
             'hands_id'     => $inventory['hands']->id,
             'neck_id'      => $inventory['neck']->id,
             'ring_id'      => $inventory['ring']->id,
             'earring_id'   => $inventory['earring']->id,
             'shield_id'    => isset($inventory['shield']) ? $inventory['shield']->id : null,
         ]);
       
         // check if any item was changed -> delete gear check if so
        $valid_gear_check = $this->loadoutService->isGearCheckStillValid($originalLoadout, $loadout);

        $status = [
            'type'    => 'success',
            'message' => 'Loadout edited successfully',
        ];

        if ( !$valid_gear_check ) {
            // base items changed; remove gear check
            $loadout->gearCheck->delete();
            $notice_msg = "gear check approval was removed because the items were changed.";

            $status = [
                'type'    => 'warning',
                'message' => 'Loadout edited successfully. However, ' . $notice_msg,
            ];

            Log::info("({$loadout->character->id}) {$loadout->character->name}'s $notice_msg");
        }

        return redirect(route('dashboard'))->with([
              'status' => $status,
          ]);
    }

    public function destroy(Loadout $loadout)
    {
        Loadout::destroy($loadout);

        // TODO: also remove from session?

        return redirect(route('dashboard'))->with([
              'status' => [
                  'type'    => 'success',
                  'message' => 'Loadout deleted successfully',
              ],
          ]);
    }
}