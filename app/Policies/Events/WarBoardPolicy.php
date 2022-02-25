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
        
    }

    public function viewAny(User $user) : bool
    {
        return $user->canAny([
            'view warboards', 
            'view own company warboards', 
            'view own faction company warboards'
        ]);
    }

    public function view(User $user, WarBoard $warBoard) : bool
    {
        return (
            (
                $user->can('view own company warboards') 
                &&
                $user->company()->id == $warBoard->company->id
            )
            ||
            (
                $user->can('view own faction warboards') 
                &&
                $user->faction()->id == $warBoard->company->faction->id
            )
        );
    }

    public function create(User $user) : bool
    {
        return $user->canAny([
            'create warboards', 
            'create own company warboards', 
            'create own faction warboards'
        ]);
    }

    public function update(User $user, \App\Models\Events\WarBoard $warBoard) : bool
    {
        return (
            $user->can('edit warboards') 
            || ( 
            !empty($user->company())
                &&
                (
                    (
                        $user->can('edit own company warboards') 
                        &&
                        $user->company()->id == $warBoard->company->id 
                    )
                    ||
                    (
                        $user->can('edit own faction warboards') 
                        &&
                        $user->faction()->id == $warBoard->company->faction->id
                    )
                )
            )
        );
    }

    public function delete(User $user, WarBoard $warBoard) : bool
    {
        return (
            $user->can('delete warboards') 
            || ( 
            !empty($user->company())
                &&
                (
                    (
                        $user->can('delete own company warboards') 
                        &&
                        $user->company()->id == $warBoard->company->id 
                    )
                    ||
                    (
                        $user->can('delete own faction warboards') 
                        &&
                        $user->faction()->id == $warBoard->company->faction->id
                    )
                )
            )
        );
    }

    public function restore(User $user, \App\Models\Events\WarBoard $warBoard) : bool
    {
        return $this->delete($user, $warBoard->company);
    }

    public function forceDelete(User $user, \App\Models\Events\WarBoard $warBoard) : bool
    {
        return false;
    }
}