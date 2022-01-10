<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoadoutUpsertRequest extends FormRequest
{
    public function rules() : array
    {
        return [
//            'name' => ['string', 'max:255'],
            'weight' => ['required', 'numeric', 'max:255'],
            'character' => ['required', 'integer', 'exists:characters,id'],
            'main' => ['required', 'integer', 'exists:weapons,id'],
            'offhand' => ['required', 'integer', 'exists:weapons,id'],
        ];
    }
}