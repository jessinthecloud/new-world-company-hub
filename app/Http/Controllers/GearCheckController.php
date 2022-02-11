<?php

namespace App\Http\Controllers;

use App\Models\Characters\Loadout;
use App\Models\GearCheck;
use Illuminate\Http\Request;

class GearCheckController extends Controller
{
    /**
     * Approve a Loadout's war readiness
     * 
     * @param \Illuminate\Http\Request       $request
     * @param \App\Models\Characters\Loadout $loadout
     *
     * @return 
     */
    public function __invoke(Request $request, Loadout $loadout)
    {
        // consul only -- middleware on route
        $approver = $request->user()->character();
        
        // don't allow mass assignment
        $check = new GearCheck();
        $check->approver_id = $approver->id;
        $check->loadout_id = $loadout->id;
        
        $status = $check->save();
        
        if(!$status){
            return redirect(route('loadouts.show', ['loadout'=>$loadout->id]))->with([
                'status'=> [
                    'type'=>'error',
                    'message' => 'Loadout approval failed. Please try again.'
                ]
            ]);
        }
        
        return redirect(route('dashboard'))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Loadout approved successfully.'
            ]
        ]);
    }
}