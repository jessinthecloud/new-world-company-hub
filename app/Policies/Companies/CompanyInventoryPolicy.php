<?php

namespace App\Policies\Companies;

use App\OldCompanyInventory;
use App\Models\Companies\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/** @deprecated */
class CompanyInventoryPolicy
{
    use HandlesAuthorization;

    /**
     * To check specific permissions via policy:
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

    /**
     * Check if user can view any company's inventories
     *
     * @param \App\Models\User $user
     * @param string           $class
     *
     * @return bool
     */
    public function viewAny( User $user, string $class=\App\OldCompanyInventory::class ) : bool
    {
        return $user->canAny([
            'view guildbanks', 
            'view own company guildbanks', 
            'view own faction company guildbanks'
        ]);
    }

    /**
     * Check if user can view the inventories of all companies
     *
     * @param \App\Models\User $user
     * @param string           $class
     *
     * @return bool
     */
    public function viewAll( User $user, string $class=\App\OldCompanyInventory::class ) : bool
    {
        return $user->can(['view guildbanks']);
    }

    /**
     * Can user view this company's inventory
     *
     * @param \App\Models\User              $user
     * @param \App\Models\Companies\CompanyInventory $company
     * @param string                        $class
     *
     * @return bool
     */
    public function view( User $user, OldCompanyInventory $company, string $class=\App\OldCompanyInventory::class ) : bool
    {
        if($this->viewAll($user)){
            return true;
        }
        
        return (
            (
                $user->can('view own company guildbanks') 
                &&
                $user->company()->id == $company->id
            )
            ||
            (
                $user->can('view own faction guildbanks') 
                &&
                $user->faction()->id == $company->faction->id
            )
        );
    }

    /**
     * @param \App\Models\User         $user
     * @param \App\OldCompanyInventory $company
     * @param string                   $class
     *
     * @return bool
     */
    public function create( User $user, OldCompanyInventory $company, string $class=\App\OldCompanyInventory::class ) : bool
    {
        return $user->canAny([
            'create guildbanks', 
            'create own company guildbanks', 
            'create own faction guildbanks'
        ]);
    }

    /**
     * @param \App\Models\User              $user
     * @param \App\Models\Companies\CompanyInventory $company
     * @param string                        $class
     *
     * @return bool
     */
    public function update( User $user, OldCompanyInventory $company, string $class=\App\OldCompanyInventory::class ) : bool
    {
        return (
            $user->can('edit guildbanks') 
            || ( 
            !empty($user->company())
                &&
                (
                    (
                        $user->can('edit own company guildbanks') 
                        &&
                        $user->company()->id == $company->id 
                    )
                    ||
                    (
                        $user->can('edit own faction guildbanks') 
                        &&
                        $user->faction()->id == $company->faction->id
                    )
                )
            )
        );
    }

    /**
     * @param \App\Models\User              $user
     * @param \App\Models\Companies\CompanyInventory $company
     * @param string                        $class
     *
     * @return bool
     */
    public function delete( User $user, OldCompanyInventory $company, string $class=\App\OldCompanyInventory::class ) : bool
    {
        return (
            $user->can('delete guildbanks') 
            || ( 
            !empty($user->company())
                &&
                (
                    (
                        $user->can('delete own company guildbanks') 
                        &&
                        $user->company()->id == $company->id 
                    )
                    ||
                    (
                        $user->can('delete own faction guildbanks') 
                        &&
                        $user->faction()->id == $company->faction->id
                    )
                )
            )
        );
    }

    /**
     * @param \App\Models\User              $user
     * @param \App\Models\Companies\CompanyInventory $company
     *
     * @return bool
     */
    public function restore( User $user, OldCompanyInventory $company, string $class=\App\OldCompanyInventory::class ) : bool
    {
        return $this->delete($user, $company);
    }

    /**
     * @param \App\Models\User              $user
     * @param \App\Models\Companies\CompanyInventory $company
     *
     * @return bool
     */
    public function forceDelete( User $user, OldCompanyInventory $company, string $class=\App\OldCompanyInventory::class ) : bool
    {
        return false;
    }
}