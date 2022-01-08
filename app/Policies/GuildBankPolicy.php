<?php

namespace App\Policies;

use App\Models\GuildBank;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GuildBankPolicy
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

    public function view( User $user, GuildBank $guildBank ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, GuildBank $guildBank ) : bool
    {
        //
    }

    public function delete( User $user, GuildBank $guildBank ) : bool
    {
        //
    }

    public function restore( User $user, GuildBank $guildBank ) : bool
    {
        //
    }

    public function forceDelete( User $user, GuildBank $guildBank ) : bool
    {
        //
    }
}