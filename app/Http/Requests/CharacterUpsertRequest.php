<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CharacterUpsertRequest extends FormRequest
{
    public function rules() : array
    {
        return [
           'name' => ['required', 'string', 'max:255'], 
           'level' => ['required', 'numeric', 'max:255'], 
        ];
    }
}