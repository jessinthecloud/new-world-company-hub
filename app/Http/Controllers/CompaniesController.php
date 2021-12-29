<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyUpsertRequest;
use App\Models\Company;
use App\Models\Faction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CompaniesController extends Controller
{
    public function index()
    {
        $companies = Company::with('faction')->orderBy('name')->get()->mapWithKeys(function($company){
            return [$company->id => $company->name.' ('.$company->faction->name.')'];
        })->all();
        
        dump($companies);
    }

    public function choose()
    {
        $companies = Company::with('faction')->orderBy('name')->get()->mapWithKeys(function($company){
            return [$company->name.' ('.$company->faction->name.')' => $company->id];
        })->all();
        $form_action = route('companies.find');

        return view(
            'dashboard.company.choose',
            compact('companies', 'form_action')
        );
    }

    public function find(Request $request)
    {
//    ddd($request);
        return redirect(route('companies.'.$request->action, ['company'=>$request->company]));
    }

    /**
     * Show Company create form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : View
    {
        $factions = Faction::orderBy('name')->get()->mapWithKeys(function($faction){
            return [$faction->name => $faction->id];
        })->all();

        $form_action = route('companies.store');
        $button_text = 'Create';

        return view(
            'dashboard.company.create-edit',
            compact('factions', 'form_action', 'button_text')
        );
    }

    public function store( CompanyUpsertRequest $request )
    {
        $validated = $request->validated();

        Company::create([
            'name' => $validated['name'],
            // relations
            'faction_id' => $validated['faction'],
        ]);
        
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Company '.$validated['name'].' created successfully'
            ]
        ]);
    }

    public function show( Company $company )
    {
        //
    }

    /**
     * Company edit form
     *
     * @param \App\Models\Company $company
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit( Company $company )
    {
        $company = $company->load('faction');

        $factions = Faction::distinct()->get()->mapWithKeys(function($faction){
            return [$faction->name => $faction->id];
        })->all();

        $faction_options = '';
        foreach($factions as $text => $value) {
            $faction_options .= '<option value="'.$value.'"';
            if($company->faction->id === $value){
                $faction_options .= ' SELECTED ';
            }
            $faction_options .= '>'.$text.'</option>';
        }

        return view(
            'dashboard.company.create-edit',
            [
                'company' => $company,
                'faction_options' => $faction_options,
                'method' => 'PUT',
                'form_action' => route('companies.update', ['company'=>$company]),
                'button_text' => 'Edit',
            ]
        );
    }

    public function update( CompanyUpsertRequest $request, Company $company )
    {
        $validated = $request->validated();

        $company->name = $validated['name'];
        // relations
        $company->faction()->associate($validated['faction']);
        $company->save();
       
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Company '.$validated['name'].' updated successfully'
            ]
        ]);
    }

    public function destroy( Company $company )
    {
        Company::destroy($company);

        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Company '.$company->name.' deleted successfully'
            ]
        ]);
    }
}