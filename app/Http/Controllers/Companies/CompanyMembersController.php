<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Models\Characters\Character;
use App\Models\Companies\Company;

class CompanyMembersController extends Controller
{
    public function destroy( Company $company, Character $character )
    {

        $character->company_id = null;    
        $character->save();
        
        // TODO : remove appropriate permissions/roles from user as well 
        
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Character removed successfully'
            ]
        ]);
    }
}