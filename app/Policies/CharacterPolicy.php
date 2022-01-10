<?php

namespace App\Policies;

use App\Models\Character;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * To check specific permissions via this policy:
     *
     * Gate::allows('viewAny', App\Models\Character::character);
     *
     * OR in a blade template:
     * @can('viewAny', App\Models\Character::character) <elements/> @endcan
     *
     * OR in a controller method:
     * $this->authorize('viewAny', App\Models\Character::character);
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny( User $user ) : bool
    {
        return $user->canAny([
            'view characters', 
            'view own characters', 
            'view own company characters',
            'view own faction characters'
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
        return $user->can(['view characters']);
    }

    public function view( User $user, Character $character ) : bool
    {
        return (
            $user->can(['view characters']) 
            ||
            (
                (
                    $user->can('view own characters')
                    &&
                    $user->where('characters.id', $character->id)
                )
                ||
                (
                    $user->can('view own company characters') 
                    && 
                    $user->where('characters.company.id', $character->company->id)
                )
                ||
                (
                    $user->can('view own faction characters') 
                    && 
                    $user->where('characters.company.faction.id', $character->faction->id)
                )
            ) 
        );
    }

    public function create( User $user ) : bool
    {
        return $user->canAny(['create characters', 'create own characters', 'create company characters', 'create faction characters']);
    }

    public function update( User $user, Character $character ) : bool
    {
        return (
            $user->can(['edit characters']) 
            ||
            (
                (
                    $user->can('edit own characters')
                    &&
                    $user->where('characters.id', $character->id)
                )
                ||
                (
                    $user->can('edit own company characters') 
                    && 
                    $user->where('characters.company.id', $character->company->id)
                )
                ||
                (
                    $user->can('edit own faction characters') 
                    && 
                    $user->where('characters.company.faction.id', $character->faction->id)
                )
            ) 
        );
    }

    public function delete( User $user, Character $character ) : bool
    {
        return (
            $user->can(['delete characters']) 
            ||
            (
                (
                    $user->can('delete own characters')
                    &&
                    $user->where('characters.id', $character->id)
                )
                ||
                (
                    $user->can('delete own company characters') 
                    && 
                    $user->where('characters.company.id', $character->company->id)
                )
                ||
                (
                    $user->can('delete own faction characters') 
                    && 
                    $user->where('characters.company.faction.id', $character->faction->id)
                )
            ) 
        );
    }

    public function restore( User $user, Character $character ) : bool
    {
        return $this->delete($user, $character);
    }

    public function forceDelete( User $user, Character $character ) : bool
    {
        return false;
    }
}