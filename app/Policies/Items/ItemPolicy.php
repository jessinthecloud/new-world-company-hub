<?php

namespace App\Policies\Items;

use App\Models\Items\OldItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ItemPolicy
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

    public function view( User $user, OldItem $item ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, OldItem $item ) : bool
    {
        //
    }

    public function delete( User $user, OldItem $item ) : bool
    {
        //
    }

    public function restore( User $user, OldItem $item ) : bool
    {
        //
    }

    public function forceDelete( User $user, OldItem $item ) : bool
    {
        //
    }
}