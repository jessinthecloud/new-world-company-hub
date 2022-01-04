<?php

namespace App\Policies;

use App\Models\Roster;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RosterPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * To check specific permissions via this policy:
     *
     * Gate::allows('viewAny', App\Models\Roster::character);
     *
     * OR in a blade template:
     * @can('viewAny', App\Models\Roster::character) <elements/> @endcan
     *
     * OR in a controller method:
     * $this->authorize('viewAny', App\Models\Roster::character);
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny( User $user ) : bool
    {
        return $user->canAny([
            'view rosters', 
            'view own rosters', 
            'view own company rosters',
            'view own faction rosters'
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
        return $user->can(['view rosters']);
    }

    public function view( User $user, Roster $roster ) : bool
    {
        return (
            $user->can(['view rosters']) 
            ||
            (
                (
                    $user->can('view own rosters')
                    &&
                    $user->where('rosters.id', $roster->id)
                )
                ||
                (
                    $user->can('view own company rosters') 
                    && 
                    $user->where('rosters.company.id', $roster->company->id)
                )
                ||
                (
                    $user->can('view own faction rosters') 
                    && 
                    $user->where('rosters.company.faction.id', $roster->faction->id)
                )
            ) 
        );
    }

    public function create( User $user ) : bool
    {
        return $user->canAny(['create rosters', 'create company rosters', 'create faction rosters']);
    }

    public function update( User $user, Roster $roster ) : bool
    {
        return (
            $user->can(['edit rosters']) 
            ||
            (
                (
                    $user->can('edit own rosters')
                    &&
                    $user->where('rosters.id', $roster->id)
                )
                ||
                (
                    $user->can('edit own company rosters') 
                    && 
                    $user->where('rosters.company.id', $roster->company->id)
                )
                ||
                (
                    $user->can('edit own faction rosters') 
                    && 
                    $user->where('rosters.company.faction.id', $roster->faction->id)
                )
            ) 
        );
    }
    
    public function import( User $user ) : bool
    {
        return (
            $user->can(['import rosters']) 
            ||
            (
                (
                    $user->can('import own company rosters') 
                    && 
                    $user->where('rosters.company.id', $user->character()->company->id)
                )
                ||
                (
                    $user->can('import own faction rosters') 
                    && 
                    $user->where('rosters.company.faction.id', $user->character()->faction->id)
                )
            ) 
        );
    }

    public function delete( User $user, Roster $roster ) : bool
    {
        return (
            $user->can(['delete rosters']) 
            ||
            (
                (
                    $user->can('delete own rosters')
                    &&
                    $user->where('rosters.id', $roster->id)
                )
                ||
                (
                    $user->can('delete own company rosters') 
                    && 
                    $user->where('rosters.company.id', $roster->company->id)
                )
                ||
                (
                    $user->can('delete own faction rosters') 
                    && 
                    $user->where('rosters.company.faction.id', $roster->faction->id)
                )
            ) 
        );
    }

    public function restore( User $user, Roster $roster ) : bool
    {
        return $this->delete($user, $roster);
    }

    public function forceDelete( User $user, Roster $roster ) : bool
    {
        return false;
    }
}