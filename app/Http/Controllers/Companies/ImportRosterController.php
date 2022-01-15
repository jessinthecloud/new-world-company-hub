<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Imports\RosterImport;
use App\Models\Company;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use function redirect;
use function view;

class ImportRosterController extends Controller
{
    public function create()
    {
        $companies = Company::with('faction')->orderBy('name')->get()->mapWithKeys(function($company){
            return [$company->id => $company->name.' ('.$company->faction->name.')'];
        })->all();
        return view('dashboard.import', [
            'companies' => $companies
        ]);
    }

    public function store( Request $request )
    {
        $validated = $request->validate([
            'company' => ['required', 'exists:companies,id', 'max:100'],
            'import' => ['required', 'file', 'max:1000', 'mimes:xlsx,xls,csv'],
        ]);

        $rosterImport = new RosterImport($validated['company']);
//        $rosterImport->onlySheets(2);

        $e = Excel::import($rosterImport, $validated['import']);

        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Roster imported successfully'
            ]
        ]);
    
    }
}