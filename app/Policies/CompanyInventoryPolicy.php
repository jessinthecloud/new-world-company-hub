<?php

namespace App\Policies;

use App\Models\Companies\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyInventoryPolicy
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

    public function view( User $user, Company $company ) : bool
    {
        //
    }

    public function create( User $user ) : bool
    {
        //
    }

    public function update( User $user, Company $company ) : bool
    {
        //
    }

    public function delete( User $user, Company $company ) : bool
    {
        //
    }

    public function restore( User $user, Company $company ) : bool
    {
        //
    }

    public function forceDelete( User $user, Company $company ) : bool
    {
        //
    }
}