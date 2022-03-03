<?php

namespace App\Policies;

use App\Models\CompanyInventory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyInventoryPolicy
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

    public function view(User $user, CompanyInventory $companyInventory) : bool
    {
        //
    }

    public function create(User $user) : bool
    {
        //
    }

    public function update(User $user, CompanyInventory $companyInventory) : bool
    {
        //
    }

    public function delete(User $user, CompanyInventory $companyInventory) : bool
    {
        //
    }

    public function restore(User $user, CompanyInventory $companyInventory) : bool
    {
        //
    }

    public function forceDelete(User $user, CompanyInventory $companyInventory) : bool
    {
        //
    }
}