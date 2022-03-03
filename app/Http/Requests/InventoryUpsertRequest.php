<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InventoryUpsertRequest extends FormRequest
{
    public function authorize() : bool
    {
        return $this->user()->hasRole('banker');
    }

    public function rules() : array
    {
        return [
            'id'         => [],
            'slug'       => ['string', 'nullable'],
            'base_id'    => [],
            'base_slug'  => ['string', 'nullable'],
            'itemType'   => ['string', 'nullable'],
            'item'       => [],
            // perks
            'perks'      => ['array', 'nullable'],
            'perks.*'    => ['exists:perks,slug', 'nullable'],
            // always input
            'gear_score' => ['required', 'numeric'],
            'rarity'     => ['required', /*new Enum(Rarity::class)*/],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'gear_score.numeric' => 'Gear score must be a number',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
//            'email' => 'email address',
        ];
    }
}