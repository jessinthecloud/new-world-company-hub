<?php

namespace App\Policies\Items;

use App\Models\Items\OldInventoryItem;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InventoryItemPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        return true;
    }

    public function viewAny( User $user ) : bool
    {
        return true;
    }

    public function view( User $user, OldInventoryItem $inventoryItem ) : bool
    {
        return true;
    }

    public function create( User $user ) : bool
    {
        return true;
    }

    public function update( User $user, OldInventoryItem $inventoryItem ) : bool
    {
        return true;
    }

    public function delete( User $user, OldInventoryItem $inventoryItem ) : bool
    {
        return true;
    }

    public function restore( User $user, OldInventoryItem $inventoryItem ) : bool
    {
        return true;
    }

    public function forceDelete( User $user, OldInventoryItem $inventoryItem ) : bool
    {
        return true;
    }
}