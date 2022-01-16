<?php

namespace App\Policies\Companies;

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
     * Gate::allows('viewAny', App\Models\Companies\GuildBank::class);
     *
     * OR in a blade template:
     * @can('viewAny', App\Models\Companies\GuildBank::class) <elements/> @endcan
     *
     * OR in a controller method:
     * $this->authorize('viewAny', App\Models\Companies\GuildBank::class);
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny( User $user ) : bool
    {
        return $user->canAny([
            'view guildbanks', 
            'view own company guildbanks', 
            'view own faction company guildbanks'
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
//    dump('COMPANY viewAll: '.$user->can(['view guildbanks']));
        return $user->can(['view guildbanks']);
    }

    public function view( User $user, GuildBank $guildBank ) : bool
    {
        return (
            $user->can(['view guildbanks']) 
            ||
            (
                (
                    $user->can('view own guildbanks')
                    &&
                    ($user->characters->where('company.id', $guildBank->company()->id)->count() > 0)
                )
                ||
                (
                    $user->can('view own company guildbanks') 
                    &&
                    ($user->characters->where('company.id', $guildBank->company()->id)->count() > 0)
                )
                ||
                (
                    $user->can('view own faction guildbanks') 
                    &&
                    ($user->characters->where('faction.id', $guildBank->company()->faction->id)->count() > 0)
                )
            ) 
        );
    }

    public function create( User $user ) : bool
    {
//dump('COMPANY create: '.$user->canAny(['create guildbanks', 'create own faction guildbanks']));
        return $user->canAny(['create guildbanks', 'create own company guildbanks', 'create own faction guildbanks']);
    }

    public function update( User $user, GuildBank $guildBank ) : bool
    {
        return (
            $user->can('edit guildbanks') 
            || ( 
                (
                    $user->can('edit own guildbanks') 
                    &&
                    ($user->characters->where('company.id', $guildBank->company()->id)->count() > 0) 
                )
                ||
                (
                    $user->can('edit own company guildbanks') 
                    &&
                    ($user->characters->where('company.id', $guildBank->company()->id)->count() > 0) 
                )
                ||
                (
                    $user->can('edit own faction guildbanks') 
                    &&
                    ($user->characters->where('faction.id', $guildBank->company()->faction->id)->count() > 0) 
                )
            )
        );
    }

    public function delete( User $user, GuildBank $guildBank ) : bool
    {
        return (
            $user->can('delete guildbanks') 
            ||
            (
                $user->can('delete own guildbanks')
                &&
                ($user->characters->where('company.id', $guildBank->company()->id)->count() > 0) 
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