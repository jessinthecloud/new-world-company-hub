<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
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

    public function view( User $user, Event $event ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Event $event ) : bool
    {
        //
    }

    public function delete( User $user, Event $event ) : bool
    {
        //
    }

    public function restore( User $user, Event $event ) : bool
    {
        //
    }

    public function forceDelete( User $user, Event $event ) : bool
    {
        //
    }
}