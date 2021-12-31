<?php

namespace App\Policies;

use App\Models\Character;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterPolicy
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

    public function view( User $user, Character $character ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Character $character ) : bool
    {
        //
    }

    public function delete( User $user, Character $character ) : bool
    {
        //
    }

    public function restore( User $user, Character $character ) : bool
    {
        //
    }

    public function forceDelete( User $user, Character $character ) : bool
    {
        //
    }
}