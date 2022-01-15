<?php

namespace App\Policies;

use App\GuildBank;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GuildBankPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * To check specific permissions via policy:
     *
     * Gate::allows('viewAny', App\Models\Companies\Company::class);
     *
     * OR in a blade template:
     * @can('viewAny', App\Models\Companies\Company::class) <elements/> @endcan
     *
     * OR in a controller method:
     * $this->authorize('viewAny', App\Models\Companies\Company::class);
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny( User $user ) : bool
    {
        return $user->canAny([
            'view guildbanks', 
            'view own guildbanks', 
            'view own company guildbanks',
            'view own faction guildbanks'
        ]);
    }

    public function viewAll( User $user ) : bool
    {
        return $user->can(['view guildbanks']);
    }

    public function view( User $user, GuildBank $guildBank ) : bool
    {
        return (
            $user->can(['view guildbanks']) 
            ||
            (
                (
                    $user->can('view own company guildbanks')
                    &&
                    $user->where('characters.company.id', $guildBank->company->id)
                )
                ||
                (
                    $user->can('view own faction guildbanks') 
                    && 
                    $user->where('characters.company.faction.id', $guildBank->company->faction->id)
                )
            ) 
        );
    }

    public function create( User $user ) : bool
    {
        return $user->canAny(['create guildbanks', 'create company guildbanks', 'create faction guildbanks']);
    }

    public function update( User $user, GuildBank $guildBank ) : bool
    {
        return (
            $user->can(['edit guildbanks']) 
            ||
            (
                (
                    $user->can('edit own company guildbanks')
                    &&
                    $user->where('characters.company.id', $guildBank->company->id)
                )
                ||
                (
                    $user->can('edit own faction guildbanks') 
                    && 
                    $user->where('characters.company.faction.id', $guildBank->company->faction->id)
                )
            ) 
        );
    }

    public function delete( User $user, GuildBank $guildBank ) : bool
    {
        return (
            $user->can(['delete guildbanks']) 
            ||
            (
                (
                    $user->can('delete own company guildbanks')
                    &&
                    $user->where('characters.company.id', $guildBank->company->id)
                )
                ||
                (
                    $user->can('delete own faction guildbanks') 
                    && 
                    $user->where('characters.company.faction.id', $guildBank->company->faction->id)
                )
            ) 
        );
    }

    public function restore( User $user, GuildBank $guildBank ) : bool
    {
        return $this->delete($user, $guildBank);
    }

    public function forceDelete( User $user, GuildBank $guildBank ) : bool
    {
        return false;
    }
}