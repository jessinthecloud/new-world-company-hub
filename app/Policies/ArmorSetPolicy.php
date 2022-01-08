<?php

namespace App\Policies;

use App\Models\ArmorSet;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ArmorSetPolicy
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

    public function view( User $user, ArmorSet $armorSet ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, ArmorSet $armorSet ) : bool
    {
        //
    }

    public function delete( User $user, ArmorSet $armorSet ) : bool
    {
        //
    }

    public function restore( User $user, ArmorSet $armorSet ) : bool
    {
        //
    }

    public function forceDelete( User $user, ArmorSet $armorSet ) : bool
    {
        //
    }
}