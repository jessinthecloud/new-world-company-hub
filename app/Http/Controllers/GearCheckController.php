<?php

namespace App\Http\Controllers;

use App\Models\Characters\Loadout;
use App\Models\GearCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
    public function approve(Request $request, Loadout $loadout)
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
        
        // todo: create GearCheck Event?
        
        return redirect(route('companies.show', [
            'company'=>$approver->company->slug
        ]))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Loadout approved successfully.'
            ]
        ]);
    }
    
    /**
     * Remove approval of a Loadout's war readiness
     * 
     * @param \Illuminate\Http\Request       $request
     * @param \App\Models\Characters\Loadout $loadout
     *
     * @return 
     */
    public function destroy(Request $request, Loadout $loadout)
    {
        $char = $loadout->character;
        $status = $loadout->gearCheck->delete();

        if(!$status){
            return redirect(route('loadouts.show', ['loadout'=>$loadout->id]))->with([
                'status'=> [
                    'type'=>'error',
                    'message' => 'Loadout disapproval failed. Please try again.'
                ]
            ]);
        }

        // check whether a consul deleted it or an edit deleted it
        $disapprover = $request->user()->character();
        $remove_reason = 'by '.$disapprover->name.' (Char ID: '.$disapprover->id.')';
        
        if($disapprover->is($char)){
            // remover is the same as the loadout owner; it was an edit
            $remove_reason = 'because the items were changed';
        } 
        
        // todo: create GearCheck Event?
        Log::info("{$char->name}'s gear check approval was removed {$remove_reason}.");
        
        return redirect(route('companies.show', [
            'company'=>$disapprover->company->slug
        ]))->with([
            'status'=> [
                'type'=>'success',
                'message' => 'Loadout disapproved successfully.'
            ]
        ]);
    }
}

    