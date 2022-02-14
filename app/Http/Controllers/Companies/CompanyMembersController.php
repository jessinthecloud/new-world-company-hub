<?php

namespace App\Http\Controllers\Companies;

use App\Exports\CompanyMembersExport;
use App\Http\Controllers\Controller;
use App\Models\Characters\Character;
use App\Models\Companies\Company;
use Maatwebsite\Excel\Facades\Excel;

class CompanyMembersController extends Controller
{
    public function export(Company $company)
    {
        return Excel::download(
            new CompanyMembersExport($company), 
            $company->name.'_members.xlsx'
        );
    }

    public function destroy(Company $company, Character $character)
    {
        $character->company_id = null;
        $character->save();

        // TODO : remove appropriate permissions/roles from user as well 

        return redirect(route('companies.show', [
            'company' => $company->slug
        ]))->with([
            'status' => [
                'type'    => 'success',
                'message' => 'Member removed successfully',
            ],
        ]);
    }
}