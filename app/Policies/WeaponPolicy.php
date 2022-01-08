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
        //
    }

    public function view( User $user, Weapon $weapon ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Weapon $weapon ) : bool
    {
        //
    }

    public function delete( User $user, Weapon $weapon ) : bool
    {
        //
    }

    public function restore( User $user, Weapon $weapon ) : bool
    {
        //
    }

    public function forceDelete( User $user, Weapon $weapon ) : bool
    {
        //
    }
}