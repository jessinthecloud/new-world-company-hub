<?php

namespace App\Policies\Companies;

use App\Models\Companies\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /**
     * To check specific permissions via this policy:
     *
     * Gate::allows('viewAny', App\Models\Companies\Company::class);
     *
     * OR in a blade template:
     * @can('viewAny', App\Models\Companies\Company::class) <elements/> @endcan
     *
     * OR in a controller method:
     * $this->authorize('viewAny', App\Models\Companies\Company::class);
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny( User $user ) : bool
    {
//dump('COMPANY viewAny: '.$user->canAny(['view companies', 'view own companies', 'view faction companies']));    
        return $user->canAny([
            'view companies', 
            'view own companies', 
            'view own faction companies'
        ]);
    }
    
    /**
     * 
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAll( User $user ) : bool
    {
//    dump('COMPANY viewAll: '.$user->can(['view companies']));
        return $user->can(['view companies']);
    }

    public function view( User $user, Company $company ) : bool
    {
        return (
            $user->can(['view companies']) 
            ||
            (
                !empty($user->characters->all())
                &&
                (
                    (
                        $user->can('view own companies')
                        &&
                        $user->characters->where('company.id', $company->id)
                    )
                    ||
                    (
                        $user->can('view own faction companies') 
                        &&
                        ($user->characters->where('faction.id', $company->faction->id)->count() > 0)
                    )
                )
            ) 
        );
    }

    public function create( User $user ) : bool
    {
//dump('COMPANY create: '.$user->canAny(['create companies', 'create own faction companies']));
        return $user->canAny(['create companies', 'create own faction companies']);
    }

    public function update( User $user, Company $company ) : bool
    {
        return (
            $user->can('edit companies') 
            || (
                !empty($user->characters->all())
                &&
                ( 
                    (
                        $user->can('edit own companies') 
                        &&
                        ($user->characters->where('company.id', $company->id)->count() > 0) 
                    ) 
                    ||
                    (
                        $user->can('edit own faction companies') 
                        &&
                        ($user->characters->where('faction.id', $company->faction->id)->count() > 0) 
                    )
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
                !empty($user->characters->all())
                &&
                ($user->characters->where('company.id', $company->id)->count() > 0) 
            )
        );
    }

    public function restore( User $user, Company $company ) : bool
    {
        return $this->delete($user, $company);
    }

    public function forceDelete( User $user, Company $company ) : bool
    {
        return false;
    }
}