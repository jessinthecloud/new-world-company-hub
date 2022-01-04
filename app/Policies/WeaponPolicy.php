<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Weapon;
use Illuminate\Auth\Access\HandlesAuthorization;

class WeaponPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny( User $user ) : bool
    {
        return false;
    }

    public function view( User $user, Weapon $weapon ) : bool
    {
        return false;
    }

    public function create( User $user ) : bool
    {
        return false;
    }

    public function update( User $user, Weapon $weapon ) : bool
    {
        return false;
    }

    public function delete( User $user, Weapon $weapon ) : bool
    {
        return false;
    }

    public function restore( User $user, Weapon $weapon ) : bool
    {
        return false;
    }

    public function forceDelete( User $user, Weapon $weapon ) : bool
    {
        return false;
    }
}