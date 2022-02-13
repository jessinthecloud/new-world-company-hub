<?php

namespace App\Http\Requests;

use App\Models\Faction;
use Illuminate\Foundation\Http\FormRequest;

class FactionUpsertRequest extends FormRequest
{
    public function authorize() : bool
    {
        return $this->route('faction') != null
            ? $this->user()->can('update', $this->route('faction')) 
            : $this->user()->can('create', Faction::class);
    }

    public function rules() : array
    {
        return [
            //
        ];
    }
}