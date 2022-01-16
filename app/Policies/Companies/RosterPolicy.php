<?php

namespace App\Policies\Companies;

use App\Models\Companies\Roster;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use function dump;

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
     * Gate::allows('viewAny', App\Models\Companies\Roster::character);
     *
     * OR in a blade template:
     * @can('viewAny', App\Models\Companies\Roster::character) <elements/> @endcan
     *
     * OR in a controller method:
     * $this->authorize('viewAny', App\Models\Companies\Roster::character);
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny( User $user ) : bool
    {
//dump('ROSTER viewAny: '.$user->canAny(['view rosters', 'view own rosters', 'view faction rosters']));    
        return $user->canAny([
            'view rosters', 
            'view own rosters', 
            'view own company rosters',
            'view own faction rosters',
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
                    ($user->rosters()->where('id', $roster->id)->count() > 0)
                )
                ||
                (
                    $user->can('view own company rosters') 
                    &&
                    ($user->rosters()->where('company.id', $roster->company->id)->count() > 0)
                )
                ||
                (
                    $user->can('view own faction rosters') 
                    &&
                    ($user->rosters()->where('faction.id', $roster->faction->id)->count() > 0)
                )
            ) 
        );
    }

    public function create( User $user ) : bool
    {
        return $user->canAny(['create rosters', 'create own rosters', 'create own company rosters', 'create own faction rosters']);
    }

    public function update( User $user, Roster $roster ) : bool
    {
        return (
            $user->can('edit rosters') 
            || ( 
                (
                    $user->can('edit own rosters') 
                    &&
                    ($user->rosters()->where('id', $roster->id)->count() > 0) 
                ) 
                ||
                (
                    $user->can('edit own company rosters') 
                    &&
                    ($user->rosters()->where('company.id', $roster->company->id)->count() > 0) 
                )
                ||
                (
                    $user->can('edit own faction rosters') 
                    &&
                    ($user->rosters()->where('company.faction.id', $roster->faction->id)->count() > 0) 
                )
            )
        );
    }

    public function delete( User $user, Roster $roster ) : bool
    {
        return (
            $user->can('delete rosters') 
            ||
            (
                (
                    $user->can('delete own rosters')
                    &&
                    ($user->characters->where('company.roster.id', $roster->id)->count() > 0)
                )
                ||
                (
                    $user->can('delete own company rosters') 
                    &&
                    ($user->characters->where('company.id', $roster->company->id)->count() > 0) 
                )
                ||
                (
                    $user->can('delete own faction rosters') 
                    &&
                    ($user->characters->where('faction.id', $roster->faction->id)->count() > 0) 
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
    
    public function import( User $user ) : bool
    {
        return (
            $user->can(['import rosters']) 
            ||
            (
                (
                    $user->can('import own company rosters')
                    &&
                    (
                        ($user->rosters()->where('company.id', $user->character()->company->id)->count() > 0)
                    ||
                        ($user->characters->where('company.id', $user->character()->company->id)->count() > 0)
                    )
                )
                ||
                (
                    $user->can('import own faction rosters') 
                    &&
                    (
                        ($user->rosters()->where('company.faction.id', $user->character()->faction->id)->count() > 0)
                        ||
                        ($user->characters->where('company.faction.id', $user->character()->faction->id)->count() > 0)
                    )
                )
            ) 
        );
    }
}