<?php

namespace App\Http\Controllers;

use App\Imports\RosterImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function create( Request $request )
    {
        return view('dashboard.import');
    }

    public function store( Request $request )
    {
        $validated = $request->validate([
            'import' => ['required', 'file', 'max:1000', 'mimes:xlsx,xls,csv'],
        ]);
        
        $rosterImport = new RosterImport;
//        $rosterImport->onlySheets(1);
        
        Excel::import($rosterImport, $validated['import']);
      
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Roster imported successfully'
            ]
        ]);
    
    }
}