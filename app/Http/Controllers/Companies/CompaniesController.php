<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyUpsertRequest;
use App\Models\Characters\CharacterClass;
use App\Models\Companies\Company;
use App\Models\Faction;
use App\Models\Items\OldBaseWeapon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use function dump;
use function redirect;
use function route;
use function view;

class CompaniesController extends Controller
{
    public function index()
    {
        $companies = Company::asArrayForDropDown();
        
        dump($companies);
    }

    public function choose()
    {
        $companies = Company::asArrayForDropDown();
        $form_action = route('companies.find');

        return view(
            'dashboard.company.choose',
            compact('companies', 'form_action')
        );
    }

    public function find(Request $request)
    {
//    ddd($request);
        return redirect(
            route('companies.'.$request->action, [
                'company'=>$request->company
            ])
        );
    }

    /**
     * Show Company create form
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create() : View
    {
        $factions = Faction::asArrayForDropDown();

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
            'slug' => Str::slug($validated['name']),
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

    /**
     * Company roster (entire list of company members)
     * 
     */
    public function show(Company $company)
    {

        $classes = collect(CharacterClass::asArrayForDropDown());
        
        return view('company.show', 
            compact('company', 'classes')
        );
    }

    /**
     * Company edit form
     *
     * @param \App\Models\Companies\Company $company
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit( Company $company )
    {
        $company = $company->load('faction');

        $factions = Faction::asArrayForDropDown();

        $faction_options = '';
        foreach($factions as $value => $text) {
            $faction_options .= '<option value="'.$value.'"';
            if($company->faction->slug === $value){
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
        $company->slug = isset($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);
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