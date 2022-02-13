<?php

namespace App\Http\Requests;

use App\Models\Characters\Loadout;
use App\Models\Companies\Company;
use Illuminate\Foundation\Http\FormRequest;

class CompanyUpsertRequest extends FormRequest
{
    public function authorize() : bool
    {
        $company = Company::find($this->route('company'))->first();

        return isset($company) 
            ? $this->user()->can('update', $company) 
            : $this->user()->can('create', Company::class);
    }

    public function rules() : array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
            'faction' => ['required', 'numeric', 'exists:factions,id'],
        ];
    }
}