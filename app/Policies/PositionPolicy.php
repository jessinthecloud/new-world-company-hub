<?php

namespace App\Policies;

use App\Models\Position;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PositionPolicy
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

    public function view( User $user, Position $position ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Position $position ) : bool
    {
        //
    }

    public function delete( User $user, Position $position ) : bool
    {
        //
    }

    public function restore( User $user, Position $position ) : bool
    {
        //
    }

    public function forceDelete( User $user, Position $position ) : bool
    {
        //
    }
}