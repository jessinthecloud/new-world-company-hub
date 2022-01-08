<?php

namespace App\Policies;

use App\Models\Attribute;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttributePolicy
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

    public function view( User $user, Attribute $attribute ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Attribute $attribute ) : bool
    {
        //
    }

    public function delete( User $user, Attribute $attribute ) : bool
    {
        //
    }

    public function restore( User $user, Attribute $attribute ) : bool
    {
        //
    }

    public function forceDelete( User $user, Attribute $attribute ) : bool
    {
        //
    }
}