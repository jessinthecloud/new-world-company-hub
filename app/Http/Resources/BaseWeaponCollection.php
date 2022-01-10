<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Request;

/** @see \App\Models\BaseWeapon */
class BaseWeaponCollection extends ResourceCollection
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function toArray( $request )
    {
        return [
            'data' => $this->collection,
        ];
    }
}
