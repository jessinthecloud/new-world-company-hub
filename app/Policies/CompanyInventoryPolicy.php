<?php

namespace App\Policies;

use App\Models\CompanyInventory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
    public function __construct()
    {
        //
    }

    /**
     * Check if user can view any company's inventories
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAny(User $user) : bool
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
     *
     * @return bool
     */
    public function viewAll(User $user) : bool
    {
        return $user->can(['view guildbanks']);
    }

    public function view(User $user, CompanyInventory $companyInventory) : bool
    {
        if($this->viewAll($user)){
            return true;
        }
        
        return (
            (
                $user->can('view own company guildbanks') 
                &&
                $user->company()->id == $companyInventory->company->id
            )
            ||
            (
                $user->can('view own faction guildbanks') 
                &&
                $user->faction()->id == $companyInventory->company->faction->id
            )
        );
    }

    public function create(User $user) : bool
    {
        return $user->canAny([
            'create guildbanks', 
            'create own company guildbanks', 
            'create own faction guildbanks'
        ]);
    }

    public function update(User $user, CompanyInventory $companyInventory) : bool
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
                        $user->company()->id == $companyInventory->company->id 
                    )
                    ||
                    (
                        $user->can('edit own faction guildbanks') 
                        &&
                        $user->faction()->id == $companyInventory->company->faction->id
                    )
                )
            )
        );
    }

    public function delete(User $user, CompanyInventory $companyInventory) : bool
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
                        $user->company()->id == $companyInventory->company->id 
                    )
                    ||
                    (
                        $user->can('delete own faction guildbanks') 
                        &&
                        $user->faction()->id == $companyInventory->company->faction->id
                    )
                )
            )
        );
    }

    public function restore(User $user, CompanyInventory $companyInventory) : bool
    {
        return $this->delete($user, $companyInventory);
    }

    public function forceDelete(User $user, CompanyInventory $companyInventory) : bool
    {
        return false;
    }
}