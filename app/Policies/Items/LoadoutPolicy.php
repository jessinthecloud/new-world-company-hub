<?php

namespace App\Policies\Items;

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

    /**
     * To check specific permissions via this policy:
     *
     * Gate::allows('viewAny', App\Models\\App\Models\Characters\Loadout::character);
     *
     * OR in a blade template:
     * @can('viewAny', App\Models\\App\Models\Characters\Loadout::character) <elements/> @endcan
     *
     * OR in a controller method:
     * $this->authorize('viewAny', App\Models\\App\Models\Characters\Loadout::character);
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny( User $user ) : bool
    {
        // temp disable
        return false;
        
        return $user->canAny([
            'view loadouts', 
            'view own loadouts', 
            'view own company loadouts',
            'view own faction loadouts'
        ]);
    }
    
    /**
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAll( User $user ) : bool
    {
        return $user->can(['view loadouts']);
    }

    public function view( User $user, Loadout $loadout ) : bool
    {
        return (
            $user->can(['view loadouts']) 
            ||
            (
                (
                    $user->can('view own loadouts')
                    &&
                    $user->where('loadouts.id', $loadout->id)
                )
                ||
                (
                    $user->can('view own company loadouts') 
                    && 
                    $user->where('loadout.character.company.id', $loadout->character->company->id)
                )
                ||
                (
                    $user->can('view own faction loadouts') 
                    && 
                    $user->where('loadout.character.company.faction.id', $loadout->character->faction->id)
                )
            ) 
        );
    }

    public function create( User $user ) : bool
    {
        return $user->canAny(['create loadouts', 'create own loadouts', 'create own company loadouts', 'create own faction loadouts']);
    }

    public function update( User $user, Loadout $loadout ) : bool
    {
        return (
            $user->can(['edit loadouts']) 
            ||
            (
                (
                    $user->can('edit own loadouts')
                    &&
                    $user->where('loadouts.id', $loadout->id)
                )
                ||
                (
                    $user->can('edit own company loadouts') 
                    && 
                    $user->where('loadout.character.company.id', $loadout->character->company->id)
                )
                ||
                (
                    $user->can('edit own faction loadouts') 
                    && 
                    $user->where('loadout.character.company.faction.id', $loadout->character->faction->id)
                )
            ) 
        );
    }

    public function delete( User $user, Loadout $loadout ) : bool
    {
        return (
            $user->can(['delete loadouts']) 
            ||
            (
                (
                    $user->can('delete own loadouts')
                    &&
                    $user->where('loadouts.id', $loadout->id)
                )
                ||
                (
                    $user->can('delete own company loadouts') 
                    && 
                    $user->where('loadout.character.company.id', $loadout->character->company->id)
                )
                ||
                (
                    $user->can('delete own faction loadouts') 
                    && 
                    $user->where('loadout.character.company.faction.id', $loadout->character->faction->id)
                )
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
}