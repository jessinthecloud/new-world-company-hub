<?php

namespace App\Policies;

use App\Models\Perk;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PerkPolicy
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

    public function view( User $user, Perk $perk ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Perk $perk ) : bool
    {
        //
    }

    public function delete( User $user, Perk $perk ) : bool
    {
        //
    }

    public function restore( User $user, Perk $perk ) : bool
    {
        //
    }

    public function forceDelete( User $user, Perk $perk ) : bool
    {
        //
    }
}