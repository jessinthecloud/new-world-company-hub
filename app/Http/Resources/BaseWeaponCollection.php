<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

/** @see \App\Models\Items\OldBaseWeapon */
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
