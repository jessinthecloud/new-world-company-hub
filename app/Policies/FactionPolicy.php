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

    public function viewAny( User $user ) : bool
    {
        //
    }

    public function view( User $user, Faction $faction ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Faction $faction ) : bool
    {
        //
    }

    public function delete( User $user, Faction $faction ) : bool
    {
        //
    }

    public function restore( User $user, Faction $faction ) : bool
    {
        //
    }

    public function forceDelete( User $user, Faction $faction ) : bool
    {
        //
    }
}