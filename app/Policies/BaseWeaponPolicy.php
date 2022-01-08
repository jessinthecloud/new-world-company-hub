<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BaseWeapon;
use Illuminate\Auth\Access\HandlesAuthorization;

class BaseWeaponPolicy
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

    public function view( User $user, BaseWeapon $weapon ) : bool
    {
        return false;
    }

    public function create( User $user ) : bool
    {
        return false;
    }

    public function update( User $user, BaseWeapon $weapon ) : bool
    {
        return false;
    }

    public function delete( User $user, BaseWeapon $weapon ) : bool
    {
        return false;
    }

    public function restore( User $user, BaseWeapon $weapon ) : bool
    {
        return false;
    }

    public function forceDelete( User $user, BaseWeapon $weapon ) : bool
    {
        return false;
    }
}