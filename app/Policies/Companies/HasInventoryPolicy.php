<?php

namespace App\Policies\Companies;

use App\Models\Companies\Company;
use App\Models\User;
use App\Models\ItemOwner as ItemOwnerContract;
use Illuminate\Database\Eloquent\Model;

trait HasInventoryPolicy
{
    // detect the correct owner object to check on $user
    protected function determineOwner(User $user, $owner) : Model
    {
        return ($owner instanceof Company) ? $user->company() : $user->character();
    }
    
    // determine permission string
    protected function determinePermission($ownerClass) : string
    {
        $class = is_object($ownerClass) ? $ownerClass::class : $ownerClass;
        
        // permission type name is same as class name
        if ($pos = strrpos($class, '\\')){
            return strtolower(substr($class, $pos + 1));
        }
        
        return strtolower($pos);
    }

    /**
     * Check if user can view any company's inventories
     *
     * @param \App\Models\User $user
     * @param string           $class
     *
     * @return bool
     */
    public function viewAnyInventory(User $user, string $class) : bool
    {
        $type = $this->determinePermission($class);
        
        return $user->canAny([
            'view guildbanks', 
            'view own '.$type.' guildbanks', 
            'view own faction '.$type.' guildbanks'
        ]);
    }

    /**
     * Check if user can view the inventories of all companies
     *
     * @param \App\Models\User $user
     *
     * @return bool
     */
    public function viewAllInventory(User $user) : bool
    {
        return $user->can(['view guildbanks']);
    }

    /**
     * Check if user can view the inventory of this owner
     *
     * @param \App\Models\User      $user
     * @param \App\Models\ItemOwner $owner
     *
     * @return bool
     */
    public function viewInventory(User $user, ItemOwnerContract $owner) : bool
    {
        // get the correct owner object related to the user
        $ownerRelation = $this->determineOwner($user, $owner);
        $type = $this->determinePermission($owner);
    
        if($this->viewAll($user)){
            return true;
        }
        
        return (
            (
                $user->can('view own '.$type.' guildbanks') 
                &&
                $ownerRelation->id == $owner->id
            )
            ||
            (
                $user->can('view own faction guildbanks') 
                &&
                $ownerRelation->faction()?->id == $owner->faction?->id
            )
        );
    }

    
    public function createInventory(User $user, string $class) : bool
    {
        $type = $this->determinePermission($class);
        
        return $user->canAny([
            'create guildbanks', 
            'create own '.$type.' guildbanks', 
            'create own faction guildbanks'
        ]);
    }

    public function updateInventory(User $user, ItemOwnerContract $owner) : bool
    {
        // get the correct owner object
        $ownerRelation = $this->determineOwner($user, $owner);
        $type = $this->determinePermission($owner);
    
        return (
            $user->can('edit guildbanks') 
            || ( 
            !empty($ownerRelation)
                &&
                (
                    (
                        $user->can('edit own '.$type.' guildbanks') 
                        &&
                        $ownerRelation->id == $owner->id 
                    )
                    ||
                    (
                        $user->can('edit own faction guildbanks') 
                        &&
                        $ownerRelation->faction()?->id == $owner->faction?->id
                    )
                )
            )
        );
    }

    public function deleteInventory(User $user, ItemOwnerContract $owner) : bool
    {
        // get the correct owner object
        $ownerRelation = $this->determineOwner($user, $owner);
        $type = $this->determinePermission($owner);
    
        return (
            $user->can('delete guildbanks') 
            || ( 
            !empty($ownerRelation)
                &&
                (
                    (
                        $user->can('delete own '.$type.' guildbanks') 
                        &&
                        $ownerRelation->id == $owner->id 
                    )
                    ||
                    (
                        $user->can('delete own faction guildbanks') 
                        &&
                        $ownerRelation->faction()?->id == $owner->faction?->id
                    )
                )
            )
        );
    }

    public function restoreInventory(User $user, ItemOwnerContract $owner) : bool
    {
        return $this->delete($user, $owner);
    }

    public function forceDeleteInventory(User $user, ItemOwnerContract $owner) : bool
    {
        return false;
    }
}