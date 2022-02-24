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
        return true;
    }

    public function viewAny(User $user) : bool
    {
        return true;
    }

    public function view(User $user, WarBoard $warBoard) : bool
    {
        return true;
    }

    public function create(User $user) : bool
    {
        return true;
    }

    public function update(User $user, \App\Models\Events\WarBoard $warBoard) : bool
    {
        return true;
    }

    public function delete(User $user, WarBoard $warBoard) : bool
    {
        return true;
    }

    public function restore(User $user, \App\Models\Events\WarBoard $warBoard) : bool
    {
        return true;
    }

    public function forceDelete(User $user, \App\Models\Events\WarBoard $warBoard) : bool
    {
        return true;
    }
}