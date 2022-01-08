<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WeaponSet;
use Illuminate\Auth\Access\HandlesAuthorization;

class WeaponSetPolicy
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

    public function view( User $user, WeaponSet $weaponSet ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, WeaponSet $weaponSet ) : bool
    {
        //
    }

    public function delete( User $user, WeaponSet $weaponSet ) : bool
    {
        //
    }

    public function restore( User $user, WeaponSet $weaponSet ) : bool
    {
        //
    }

    public function forceDelete( User $user, WeaponSet $weaponSet ) : bool
    {
        //
    }
}