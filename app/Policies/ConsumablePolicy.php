<?php

namespace App\Policies;

use App\Models\Consumable;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConsumablePolicy
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

    public function view( User $user, Consumable $consumable ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Consumable $consumable ) : bool
    {
        //
    }

    public function delete( User $user, Consumable $consumable ) : bool
    {
        //
    }

    public function restore( User $user, Consumable $consumable ) : bool
    {
        //
    }

    public function forceDelete( User $user, Consumable $consumable ) : bool
    {
        //
    }
}