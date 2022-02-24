<?php

namespace App\Policies\Events;

use App\Models\Events\WarBoard;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class WarBoardPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny(User $user) : bool
    {
        //
    }

    public function view(User $user, WarBoard $warBoard) : bool
    {
        //
    }

    public function create(User $user) : bool
    {
        //
    }

    public function update(User $user, \App\Models\Events\WarBoard $warBoard) : bool
    {
        //
    }

    public function delete(User $user, WarBoard $warBoard) : bool
    {
        //
    }

    public function restore(User $user, \App\Models\Events\WarBoard $warBoard) : bool
    {
        //
    }

    public function forceDelete(User $user, \App\Models\Events\WarBoard $warBoard) : bool
    {
        //
    }
}