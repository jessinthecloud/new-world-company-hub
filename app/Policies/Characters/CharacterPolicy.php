<?php

namespace App\Policies\Characters;

use App\Models\Characters\Character;
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
     * Gate::allows('viewAny', App\Models\Characters\Character::character);
     *
     * OR in a blade template:
     * @can('viewAny', App\Models\Characters\Character::character) <elements/> @endcan
     *
     * OR in a controller method:
     * $this->authorize('viewAny', App\Models\Characters\Character::character);
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny( User $user ) : bool
    {
//dump('COMPANY viewAny: '.$user->canAny(['view characters', 'view own characters', 'view faction characters']));    
        return $user->canAny([
            'view characters', 
            'view own characters', 
            'view own company characters',
            'view own faction characters',
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
//    dump('COMPANY viewAll: '.$user->can(['view characters']));
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
                    $user->characters->where('id', $character->id)
                )
                ||
                (
                    $user->can('view own company characters') 
                    &&
                    ($user->characters->where('company.id', $character->company->id)->count() > 0)
                )
                ||
                (
                    $user->can('view own faction characters') 
                    &&
                    ($user->characters->where('faction.id', $character->faction->id)->count() > 0)
                )
            ) 
        );
    }

    public function create( User $user ) : bool
    {
//dump('COMPANY create: '.$user->canAny(['create characters', 'create own faction characters']));
        return $user->canAny(['create characters', 'create own characters', 'create own company characters', 'create own faction characters']);
    }

    public function update( User $user, Character $character ) : bool
    {
        return (
            $user->can('edit characters') 
            || ( 
                (
                    $user->can('edit own characters') 
                    &&
                    ($user->characters->where('company.id', $character->id)->count() > 0) 
                ) 
                ||
                (
                    $user->can('edit own company characters') 
                    &&
                    ($user->characters->where('company.id', $character->company->id)->count() > 0) 
                )
                ||
                (
                    $user->can('edit own faction characters') 
                    &&
                    ($user->characters->where('faction.id', $character->faction->id)->count() > 0) 
                )
            )
        );
    }

    public function delete( User $user, Character $character ) : bool
    {
        return (
            $user->can('delete characters') 
            ||
            (
                (
                    $user->can('delete own characters')
                    &&
                    ($user->characters->where('company.id', $character->id)->count() > 0)
                )
                ||
                (
                    $user->can('delete own company characters') 
                    &&
                    ($user->characters->where('company.id', $character->company->id)->count() > 0) 
                )
                ||
                (
                    $user->can('delete own faction characters') 
                    &&
                    ($user->characters->where('faction.id', $character->faction->id)->count() > 0) 
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