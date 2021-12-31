<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function viewAny( User $user ) : bool
    {
        return $user->can(['view companies']);
    }

    public function view( User $user, Company $company ) : bool
    {
        return (
            $user->can(['view companies']) 
            ||(
                $user->load('characters.company')
                    ->where('characters.company.id', $company->id)
            ) 
        );
    }

    public function create( User $user ) : bool
    {
        return $user->hasAnyPermission(['create companies', 'create faction companies']);
    }

    public function update( User $user, Company $company ) : bool
    {
        return (
            $user->can('edit companies') 
            || ( 
                (
                    $user->can('edit own companies') 
                    &&
                    $user->load('characters.company')
                        ->where('characters.company.id', $company->id) 
                ) 
                &&
                (
                    $user->can('edit own faction companies') 
                    && 
                    $user->load('characters.company')
                        ->where('characters.company.faction.id', $company->faction->id)
                )
            )
        );
    }

    public function delete( User $user, Company $company ) : bool
    {
        return (
            $user->can('delete companies') 
            ||
            (
                $user->can('delete own companies')
                && 
                $user->load('characters.company')
                    ->where('characters.company.id', $company->id)
            )
        );
    }

    public function restore( User $user, Company $company ) : bool
    {
        return (
            $user->can('delete companies') 
            ||
            (
                $user->can('delete own companies')
                && 
                $user->load('characters.company')
                    ->where('characters.company.id', $company->id)
            )
        );
    }

    public function forceDelete( User $user, Company $company ) : bool
    {
        return false;
    }
}