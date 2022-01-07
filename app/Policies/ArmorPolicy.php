<?php

namespace App\Policies;

use App\Models\Armor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArmorPolicy
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

    public function view( User $user, Armor $armor ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Armor $armor ) : bool
    {
        //
    }

    public function delete( User $user, Armor $armor ) : bool
    {
        //
    }

    public function restore( User $user, Armor $armor ) : bool
    {
        //
    }

    public function forceDelete( User $user, Armor $armor ) : bool
    {
        //
    }
}