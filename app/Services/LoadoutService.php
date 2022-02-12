<?php

namespace App\Services;

use App\Enums\ArmorType;
use App\Enums\AttributeType;
use App\Enums\GearCheckThreshold;
use App\Enums\Rarity;
use App\Enums\WeaponType;
use App\Exceptions\MissingLoadoutSlotException;
use App\Models\Characters\Character;
use App\Models\Characters\Loadout;
use App\Models\Items\Perk;

class LoadoutService
{
    public array $equipmentSlots;

    public function __construct(protected WeaponService $weaponService, protected ArmorService $armorService)
    {
        $this->equipmentSlots = [
            'main'    => [
                'type'     => 'weapon',
                'subtype'  => null,
                'required' => true,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
            'offhand' => [
                'type'     => 'weapon',
                'subtype'  => null,
                'required' => true,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
            'head'    => [
                'type'     => 'armor',
                'subtype'  => ArmorType::from( 'Helmet' )->name,
                'required' => true,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
            'chest'   => [
                'type'     => 'armor',
                'subtype'  => ArmorType::from( 'Chest' )->name,
                'required' => true,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
            'hands'   => [
                'type'     => 'armor',
                'subtype'  => ArmorType::from( 'Gloves' )->name,
                'required' => true,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
            'legs'    => [
                'type'     => 'armor',
                'subtype'  => ArmorType::from( 'Pants' )->name,
                'required' => true,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
            'feet'    => [
                'type'     => 'armor',
                'subtype'  => ArmorType::from( 'Shoes' )->name,
                'required' => true,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
            'neck'    => [
                'type'     => 'armor',
                'subtype'  => ArmorType::from( 'Amulet' )->name,
                'required' => true,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
            'ring'    => [
                'type'     => 'armor',
                'subtype'  => ArmorType::from( 'Ring' )->name,
                'required' => true,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
            'earring' => [
                'type'     => 'armor',
                'subtype'  => ArmorType::from( 'Earring' )->name,
                'required' => true,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
            'shield'  => [
                'type'     => 'weapon',
                'subtype'  => WeaponType::Shield->value,
                'required' => false,
                'fields'   => [
                    'tier'       => null,
                    'rarity'     => null,
                    'perks'      => [],
                    'attributes' => [],
                    'gear_score' => null,
                    'name'       => null,
                ],
            ],
        ];
    }

    /**
     * Populate the old form data
     *
     * @param \App\Services\ItemService $itemService
     * @param array                     $old
     *
     * @return void
     */
    public function populateSlots( ItemService $itemService, array $old = [] )
    {
        // loop equip types
        foreach ( $this->equipmentSlots as $name => $info ) {
            // get old values

            // existing perks
            $this->equipmentSlots[ $name ]['existing_perk_options'] = $itemService->existingPerkOptions(
                array_filter( $old( 'perks' )[ $name ] ),
                Perk::asArrayForDropDown(),
            );

            // existing attributes
            [$existing_attribute_amounts, $existing_attribute_options] =
                $itemService->existingAttributeOptions(
                    array_filter( $old( 'attrs' )[ $name ] ),
                    collect( AttributeType::cases() )->sortBy( 'value' )->all(),
                    array_filter( $old( 'attribute_amounts' )[ $name ] ),
                );
            $this->equipmentSlots[ $name ]['existing_attribute_options'] = $existing_attribute_options;
            $this->equipmentSlots[ $name ]['existing_attribute_amounts'] = $existing_attribute_amounts;
        }
    }

    /**
     * @param array                            $validated
     * @param \App\Models\Characters\Character $character
     *
     * @return array
     */
    public function createItemsForSlots( array $validated, Character $character ) : array
    {
        $inventory = [];
        
        // loop slot names to create items
        foreach ( $validated['equipment_slot_names'] as $equipment_slot ) {
            if ( !isset( $validated['itemType'][ $equipment_slot ] ) ) {
                continue;
            }
            $inventory[ $equipment_slot ] = $this->createItemForSlot(
                $character,
                $equipment_slot,
                [
                    'itemType'          => $validated['itemType'][ $equipment_slot ],
                    'gear_score'        => $validated['gear_score'][ $equipment_slot ],
                    'rarity'            => $validated['rarity'][ $equipment_slot ],
                    'perks'             => $validated['perks'][ $equipment_slot ] ?? [],
                    'attribute_amounts' => $validated['attribute_amounts'][ $equipment_slot ] ?? null,
                    'attrs'             => $validated['attrs'][ $equipment_slot ] ?? [],
                    'base_id'           => $validated['base_id'][ $equipment_slot ],
                    'base_slug'         => $validated['base_slug'][ $equipment_slot ],
                    'id'                => $validated['id'][ $equipment_slot ],
                    'slug'              => $validated['slug'][ $equipment_slot ],
                    'tier'              => null,
                ]
            );
        }
        
        return $inventory;
    }

    public function createItemForSlot( Character $character, string $equipment_slot, array $values )
    {
        $service = ( strtolower( $values['itemType'] ) == 'weapon' ) ? 'weaponService' : 'armorService';
        
        $base = $this->{$service}->baseItem( $values['base_id'] );
        $values [ strtolower( $values['itemType'] ) . '_type' ] = $base->type ?? '';

        $specificItem = $this->{$service}->createSpecificItem( $values, $base );
        $specificItem = $this->{$service}->saveSpecificItemRelations(
            $values,
            $specificItem,
            $base
        );
        
        $morphableItem = $this->{$service}->createMorphableItem( $specificItem );
        
        return $this->{$service}->createInventoryItem(
            $morphableItem,
            $character
        );
    }

    /**
     * @param \App\Models\Characters\Loadout $loadout
     *
     * @return array
     */
    public function populateEquipmentSlotGroups( Loadout $loadout )
    {
        $jewelry = ['neck', 'ring', 'earring'];
        $equipment_slot = [];
        $weapon_slot = [];
        $armor_slot = [];
        $jewelry_slot = [];
        
        foreach ( array_keys( $this->equipmentSlots ) as $slot_name ) {
            $equipment_slot[ $slot_name ] = $this->populateEquipmentSlotGroup(
                $loadout, 
                $this->equipmentSlots[ $slot_name ],
                $slot_name
            );

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
        $jewelry_slot = array_filter( $jewelry_slot );
        
        return [$weapon_slot, $armor_slot, $jewelry_slot];
    }
    
    protected function populateEquipmentSlotGroup(Loadout $loadout, array $slot, string $slot_name) {

        // InventoryItem models  
        $slot['inventoryItem'] = $loadout->$slot_name;
        // item subtype
        $slot['itemType'] = isset( $loadout->$slot_name ) ? $loadout->$slot_name->item->itemable::class : null;
        // Item Model
        $slot['item'] = $loadout->$slot_name?->item;
        // specific item
        $slot['equippableItem'] = $loadout->$slot_name?->item->itemable;
        $equip_item = $slot['equippableItem'];
        // rarity color
        $slot['rarityColor'] = isset( $equip_item )
            ? Rarity::from( $equip_item->rarity )->color()
            : null;
        // rarity
        $slot['rarity'] = strtolower( $equip_item?->rarity );
        // attributes
        $slot['attributes_list'] = isset( $equip_item )
            ? implode(
                '<BR>',
                $equip_item->itemAttributes->unique()->map( function ( $attribute ) {
                    return $attribute->pivot->amount . ' ' . AttributeType::fromName( $attribute->name )->value;
                } )->all()
            )
            : [];
            
        // perks list
        $slot['perks_list'] = isset( $equip_item )
            ? implode( '<BR>', $equip_item->perks->unique()->pluck( 'name' )->all() )
            : [];

        // empty perk slots
        $slot['used_perk_slots'] = $equip_item?->numberOfUnusedPerkSlots();

        // gear check
        $slot['gear_check_color'] = isset( $equip_item )
            ? GearCheckThreshold::color( $equip_item->gear_score )
            : null;
        $slot['gear_check_label'] = isset( $equip_item )
            ? strtolower( GearCheckThreshold::getName( $equip_item->gear_score ) )
            : null;
        $slot['gear_check_status'] = isset( $equip_item )
            ? GearCheckThreshold::passes( $equip_item->gear_score )
            : null;

        // remove empty slots
        $slot = array_filter( $slot );
        
        return $slot;
    }
}