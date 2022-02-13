<?php

namespace App\Http\Requests;

use App\Models\Faction;
use Illuminate\Foundation\Http\FormRequest;

class FactionUpsertRequest extends FormRequest
{
    public function authorize() : bool
    {
        $faction = Faction::find($this->route('faction'))->first();

        return isset($faction) 
            ? $this->user()->can('update', $faction) 
            : $this->user()->can('create', Faction::class);
    }

    public function rules() : array
    {
        return [
            //
        ];
    }
}