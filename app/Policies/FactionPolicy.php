<?php

namespace App\Policies;

use App\Models\Faction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FactionPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * To check specific permissions via this policy:
     *
     * Gate::allows('viewAny', App\Models\\App\Models\Faction::class);
     *
     * OR in a blade template:
     * @can('viewAny', App\Models\\App\Models\Faction::class) <elements/> @endcan
     *
     * OR in a controller method:
     * $this->authorize('viewAny', App\Models\\App\Models\Faction::class);
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny( User $user ) : bool
    {
        return $user->canAny([
            'view factions', 
            'view own faction', 
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
        return $user->can('view factions');
    }

    public function view( User $user, Faction $faction ) : bool
    {
        return (
            $user->can('view factions') 
            ||
            (
                $user->can('view own faction')
                &&
                $user->where('characters.company.faction.id', $faction->id)
            ) 
        );
    }

    public function create( User $user ) : bool
    {
        return $user->can('create factions');
    }

    public function update( User $user, Faction $faction ) : bool
    {
        return (
            $user->can('edit factions') 
            || ( 
                (
                    $user->can('edit own factions') 
                    &&
                    $user->where('characters.company.faction.id', $faction->id) 
                )
            )
        );
    }

    public function delete( User $user, Faction $faction ) : bool
    {
        return (
            $user->can('delete factions') 
            ||
            (
                $user->can('delete own factions')
                && 
                $user->where('characters.company.faction.id', $faction->id)
            )
        );
    }

    public function restore( User $user, Faction $faction ) : bool
    {
        return (
            $user->can('delete factions') 
            ||
            (
                $user->can('delete own factions')
                && 
                $user->where('characters.company.faction.id', $faction->id)
            )
        );
    }

    public function forceDelete( User $user, Faction $faction ) : bool
    {
        return false;
    }
}