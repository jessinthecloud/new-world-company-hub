<?php

namespace App\Services;

use App\Enums\ArmorType;
use App\Enums\WeightClass;
use App\Models\Items\Armor;
use App\Models\Items\BaseArmor;
use App\Models\Items\BaseItem;
use Illuminate\Support\Str;

class ArmorService extends ItemService implements ItemServiceContract
{
    protected string $itemClass = Armor::class;
    protected string $baseItemClass = BaseArmor::class;

    public function __construct()
    {
    }

    /**
     * @return array
     */
    public function getAllBaseItems() : array
    {
        return BaseArmor::bankable()->orderBy( 'name' )->orderBy( 'tier' )->distinct()
            ->orderBy( 'name' )/*->dd()->toSql();*/
            ->get()->mapWithKeys( function ( $base_armor ) {
                $wtype = $base_armor->type;
                $type = !empty( $wtype ) ? constant( "App\Enums\ArmorType::$wtype" )->value : null;

                return [$base_armor->slug => $base_armor->name . " (" . ( !empty( $base_armor->weight_class ) ? $base_armor->weight_class . ' ' : '' ) . $type . ") Tier " . $base_armor->tier];
            } )->all();
    }

    /**
     * @param string $weight_class
     *
     * @return string
     */
    public function weightClassOptions( string $weight_class = '' ) : string
    {
        $weight_class_options = '<option value="">None</option>';
        foreach ( WeightClass::cases() as $type ) {
            $weight_class_options .= '<option value="' . $type->name . '"';
            if ( strtolower( $type->value ) == strtolower( $weight_class ) ) {
                $weight_class_options .= ' SELECTED ';
            }
            $weight_class_options .= '>' . $type->value . '</option>';
        }

        return $weight_class_options;
    }

    /**
     * @param string $itemType
     *
     * @return string
     */
    public function itemTypeOptions( string $itemType = '' ) : string
    {
        $armor_type_options = '<option value=""></option>';
        foreach ( collect( ArmorType::cases() )->sortBy( 'value' )->all() as $type ) {
            $armor_type_options .= '<option value="' . $type->name . '"';
            if ( strtolower( $type->value ) == strtolower( $itemType ) ) {
                $armor_type_options .= ' SELECTED ';
            }
            $armor_type_options .= '>' . $type->value . '</option>';
        }

        return $armor_type_options;
    }

    /**
     * @param array                           $validated
     * @param \App\Models\Items\BaseItem|null $base
     *
     * @return mixed
     */
    public function initItemAttributes( array $validated, BaseItem $base = null )
    {
        $values = [];
        
        // get base armor
        $base ??= $this->baseItem( $validated['armor'] ?? $validated['slug'] );
        
        $type_input = $validated['armor_type'];
        $type = !empty( $type_input )
            ? constant( "App\Enums\ArmorType::$type_input" )?->value
            : constant( "App\Enums\ArmorType::{$base->type}" )?->value ?? null;

        $weight_class = !empty( $validated['weight_class'] )
            ? WeightClass::from( $validated['weight_class'] )->name
            : null;

        $values ['type'] = $type;
        $values ['weight_class'] = $weight_class;

        return array_merge( 
            $values, 
            $this->initGenericItemAttributes( $validated, $values, $base )
        );
    }
}