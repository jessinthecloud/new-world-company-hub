<?php

namespace App\Policies;

use App\Models\Characters\Loadout;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LoadoutPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny( User $user ) : bool
    {
        return $user->canAny([
            'view loadouts', 
            'view own loadouts', 
            'view own company loadouts', 
            'view own faction company loadouts'
        ]);
    }

    public function view( User $user, Loadout $loadout ) : bool
    {
        return (
            $user->can('view loadouts')
            ||
            (
                $user->can('view own loadouts') 
                &&
                $user->id == $loadout->user->id
            )
            ||
            (
                $user->can('view own company loadouts') 
                &&
                $user->company()->id == $loadout->company->id
            )
            ||
            (
                $user->can('view own faction loadouts') 
                &&
                $user->faction()->id == $loadout->company->faction->id
            )
        );
    }

    public function create( User $user ) : bool
    {
        return (
            $user->can('create loadouts')
            ||
            (
                $user->can('create own loadouts') && $user->loadouts->count() < 1 
            )
            ||
            (
                $user->can('create own company loadouts') 
                &&
                $user->company()->id == $user->loadout()->company->id
            )
            ||
            (
                $user->can('create own faction loadouts') 
                &&
                $user->faction()->id == $user->loadout()->company->faction->id
            )
        );
    }

    public function update( User $user, Loadout $loadout ) : bool
    {
        return (
            $user->can('edit loadouts')
            ||
            (
                $user->can('edit own loadouts') 
                &&
                $user->id == $loadout->user->id
            )
            ||
            (
                $user->can('edit own company loadouts') 
                &&
                $user->company()->id == $loadout->company->id
            )
            ||
            (
                $user->can('edit own faction loadouts') 
                &&
                $user->faction()->id == $loadout->company->faction->id
            )
        );
    }

    public function delete( User $user, Loadout $loadout ) : bool
    {
        return (
            $user->can('delete loadouts')
            ||
            (
                $user->can('delete own loadouts') 
                &&
                $user->id == $loadout->user->id
            )
            ||
            (
                $user->can('delete own company loadouts') 
                &&
                $user->company()->id == $loadout->company->id
            )
            ||
            (
                $user->can('delete own faction loadouts') 
                &&
                $user->faction()->id == $loadout->company->faction->id
            )
        );
    }

    public function restore( User $user, Loadout $loadout ) : bool
    {
        return $this->delete($user, $loadout);
    }

    public function forceDelete( User $user, Loadout $loadout ) : bool
    {
        return false;
    }
    
    public function approve( User $user, Loadout $loadout ) : bool
    {
        return (
            $user->can('approve loadouts')
            ||
            (
                $user->can('approve own company loadouts') 
                &&
                $user->company()->id == $loadout->company->id
            )
            ||
            (
                $user->can('approve own faction loadouts') 
                &&
                $user->faction()->id == $loadout->company->faction->id
            )
        );
    }
}