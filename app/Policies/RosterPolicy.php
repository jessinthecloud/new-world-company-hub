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

    public function viewAny( User $user ) : bool
    {
        //
    }

    public function view( User $user, Roster $roster ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Roster $roster ) : bool
    {
        //
    }

    public function delete( User $user, Roster $roster ) : bool
    {
        //
    }

    public function restore( User $user, Roster $roster ) : bool
    {
        //
    }

    public function forceDelete( User $user, Roster $roster ) : bool
    {
        //
    }
}