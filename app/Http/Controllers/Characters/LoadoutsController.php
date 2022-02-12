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

        dump( $loadouts );
    }

    public function choose()
    {
        $loadouts = Loadout::asArrayForDropDown();
        $form_action = route( 'loadouts.find' );

        return view(
            'dashboard.loadout.choose',
            compact( 'loadouts', 'form_action' )
        );
    }

    public function find( Request $request )
    {
//    ddd($request);
        return redirect( route( 'loadouts.' . $request->action, ['loadout' => $request->loadout] ) );
    }

    /**
     * Show Loadout create form
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create( Request $request ) : View
    {
        if ( !empty( $request->old() ) ) {
            // on failed submission
            // populate the old form data
            $this->loadoutService->populateSlots( $this->weaponService, $request->old() );
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
                'form_action'          => route( 'loadouts.store' ),
                'button_text'          => 'Add',
            ]
        );
    }

    public function store( LoadoutUpsertRequest $request )
    {
        $validated = $request->validated();
        try {
            $inventory = $this->loadoutService->createItemsForSlots(
                $validated,
                $request->user()->character()
            );
        } catch ( ModelNotFoundException $e ) {
            Log::warning( 'Loadout creation failed: ' . $e->getMessage() );

            return redirect()->back()->with( [
                 'status' => [
                     'type'    => 'error',
                     'message' => 'Loadout creation failed. Please try again.',
                 ],
             ] )
             ->withInput()
             ;
        } /*catch (MissingLoadoutSlotException $e) {
            Log::warning( 'Loadout creation failed: ' . $e->getMessage() );
            
            $message = 'Loadout creation failed unexpectedly. Please try again.'
                .(config('app.env')!=='production' ? ' -- '.$e->getMessage() : '');
                
            return redirect()->back()->with( [
                 'status' => [
                     'type'    => 'error',
                     'message' => $message,
                 ],
             ] )
             ->withInput()
             ;
        }*/

        $loadout = Loadout::create( [
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
            'shield_id'    => isset( $inventory['shield'] ) ? $inventory['shield']->id : null,
        ] );

        // todo: fire Event?

        return redirect( route( 'dashboard' ) )->with( [
           'status' => [
               'type'    => 'success',
               'message' => 'Loadout created successfully',
           ],
       ] );
    }

    public function show( Loadout $loadout )
    {
//        dump($loadout);
//        dump($loadout->main->item->itemable->ownerInventory());

        $owner = $loadout->main->item->itemable->owner();
        $ownerType = Str::afterLast( strtolower( $owner::class ), '\\' );
        $character_name = Str::title( $loadout->character->name );
        $gear_score = $loadout->gear_score;
        $loadout_check = GearCheckThreshold::passes( $gear_score );
        $inventory = $loadout->main->item->itemable->ownerInventory();

        $weapon_slot = [];
        $armor_slot = [];
        $jewelry_slot = [];
        $equipment_slot = [];
        $jewelry = ['neck', 'ring', 'earring'];
        foreach ( array_keys( $this->loadoutService->equipmentSlots ) as $slot_name ) {
            // InventoryItem models  
            $equipment_slot[ $slot_name ]['inventoryItem'] = $loadout->$slot_name;
            // item subtype
            $equipment_slot[ $slot_name ]['itemType'] = isset( $loadout->$slot_name ) ? $loadout->$slot_name->item->itemable::class : null;
            // Item Model
            $equipment_slot[ $slot_name ]['item'] = $loadout->$slot_name?->item;
            // specific item
            $equipment_slot[ $slot_name ]['equippableItem'] = $loadout->$slot_name?->item->itemable;
            $equip_item = $equipment_slot[ $slot_name ]['equippableItem'];
            // rarity color
            $equipment_slot[ $slot_name ]['rarityColor'] = isset( $equip_item )
                ? Rarity::from( $equip_item->rarity )->color()
                : null;
            // rarity
            $equipment_slot[ $slot_name ]['rarity'] = strtolower( $equip_item?->rarity );
            // attributes
            $equipment_slot[ $slot_name ]['attributes_list'] = isset( $equip_item )
                ? implode(
                    '<BR>',
                    $equip_item->itemAttributes->unique()->map( function ( $attribute ) {
                        return $attribute->pivot->amount . ' ' . AttributeType::fromName( $attribute->name )->value;
                    } )->all()
                )
                : [];

            $equipment_slot[ $slot_name ]['perks_list'] = isset( $equip_item )
                ? implode( '<BR>', $equip_item->perks->unique()->pluck( 'name' )->all() )
                : [];

            // empty perk slots
            $equipment_slot[ $slot_name ]['used_perk_slots'] = $equip_item?->numberOfUnusedPerkSlots();

            // gear check
            $equipment_slot[ $slot_name ]['gear_check_color'] = isset( $equip_item )
                ? GearCheckThreshold::color( $equip_item->gear_score )
                : null;
            $equipment_slot[ $slot_name ]['gear_check_label'] = isset( $equip_item )
                ? strtolower( GearCheckThreshold::getName( $equip_item->gear_score ) )
                : null;
            $equipment_slot[ $slot_name ]['gear_check_status'] = isset( $equip_item )
                ? GearCheckThreshold::passes( $equip_item->gear_score )
                : null;

            // remove empty slots
            $equipment_slot[ $slot_name ] = array_filter( $equipment_slot[ $slot_name ] );

            if ( isset( $equipment_slot[ $slot_name ]['itemType'] ) ) {
                if ( str_contains( strtolower( $equipment_slot[ $slot_name ]['itemType'] ), 'weapon' ) ) {
                    $weapon_slot [] = $equipment_slot[ $slot_name ];
                } else {
                    if ( in_array( $slot_name, $jewelry ) ) {
                        $jewelry_slot [] = $equipment_slot[ $slot_name ];
                    } else {
                        $armor_slot [] = $equipment_slot[ $slot_name ];
                    }
                }
            }
        }
        $weapon_slot = array_filter( $weapon_slot );
        $armor_slot = array_filter( $armor_slot );
        $equipment_slot = array_filter( $equipment_slot );

        return view( 'loadouts.show', [
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
        ] );
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
        $characters = Character::with( 'class' )->orderBy( 'name' )->get()->mapWithKeys( function ( $class ) {
            return [$class->id => $class->name];
        } )->all();

        $loadout = $loadout->load( 'main', 'offhand', 'character' );

        $weapons = BaseWeapon::orderBy( 'name' )->get()->mapWithKeys( function ( $weapon ) {
            return [$weapon->id => $weapon->name . ' (' . $weapon->type->name . ')'];
        } )->all();

        $character_options = '';
        foreach ( $characters as $value => $text ) {
            $character_options .= '<option value="' . $value . '"';
            if ( $loadout->character->id === $value ) {
                $character_options .= ' SELECTED ';
            }
            $character_options .= '>' . $text . '</option>';
        }

        $main_options = '';
        foreach ( $weapons as $value => $text ) {
            $main_options .= '<option value="' . $value . '"';
            if ( $loadout->main->id === $value ) {
                $main_options .= ' SELECTED ';
            }
            $main_options .= '>' . $text . '</option>';
        }

        $offhand_options = '';
        foreach ( $weapons as $value => $text ) {
            $offhand_options .= '<option value="' . $value . '"';
            if ( $loadout->offhand->id === $value ) {
                $offhand_options .= ' SELECTED ';
            }
            $offhand_options .= '>' . $text . '</option>';
        }

        return view(
            'dashboard.loadout.create-edit',
            [
                'loadout'           => $loadout,
                'character_options' => $character_options,
                'main_options'      => $main_options,
                'offhand_options'   => $offhand_options,
                'method'            => 'PUT',
                'form_action'       => route( 'loadouts.update', ['loadout' => $loadout] ),
                'button_text'       => 'Edit',
            ]
        );
    }

    public function update( LoadoutUpsertRequest $request, Loadout $loadout )
    {
        /*        $validated = $request->validated();
        //dump($validated, $loadout, $loadout->weapons->pluck('pivot')->pluck('level'));
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
                ]);*/
    }

    public function destroy( Loadout $loadout )
    {
        Loadout::destroy( $loadout );

        return redirect( route( 'dashboard' ) )->with( [
                                                           'status' => [
                                                               'type'    => 'success',
                                                               'message' => 'Loadout deleted successfully',
                                                           ],
                                                       ] );
    }
}