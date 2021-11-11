<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
        $actions = ['do all', 'create', 'edit', 'view', 'delete'];
        $ownership = ['for all', 'for my own', "for my company's", "for my faction's", 'for specific'];
        $models = [
            'User', 'Role', 'Permission', 'Faction', 'Company', 'Character', 'Loadout', 'Class', 'Class Type', 'Weapon', 'Weapon Type', 'Rank', 'Skill', 'Skill Type', 'Event', 'Roster', 'Position', 'House', 'Trophy', 'Trophy Type',
        ];
        
        // create permissions
        /*Permission::create(['name' => 'do all']);
        
        Permission::create(['name' => 'view all']);
        Permission::create(['name' => 'create all']);
        Permission::create(['name' => 'edit all']);
        Permission::create(['name' => 'delete all']);*/
        
    // -- characters --
        Permission::create(['name' => 'view characters']);
        Permission::create(['name' => 'create characters']);
        Permission::create(['name' => 'edit characters']);
        Permission::create(['name' => 'delete characters']);
        // their own
        Permission::create(['name' => 'view own characters']);
        Permission::create(['name' => 'create own characters']);
        Permission::create(['name' => 'edit own characters']);
        Permission::create(['name' => 'delete own characters']);
        // their companies'
        Permission::create(['name' => 'view own company characters']);
        Permission::create(['name' => 'create own company characters']);
        Permission::create(['name' => 'edit own company characters']);
        Permission::create(['name' => 'delete own company characters']);
        // their factions'
        Permission::create(['name' => 'view own faction characters']);
        Permission::create(['name' => 'create own faction characters']);
        Permission::create(['name' => 'edit own faction characters']);
        Permission::create(['name' => 'delete own faction characters']);
    // -- loadouts --
        Permission::create(['name' => 'view loadouts']);
        Permission::create(['name' => 'create loadouts']);
        Permission::create(['name' => 'edit loadouts']);
        Permission::create(['name' => 'delete loadouts']);
        // their own
        Permission::create(['name' => 'view own loadouts']);
        Permission::create(['name' => 'create own loadouts']);
        Permission::create(['name' => 'edit own loadouts']);
        Permission::create(['name' => 'delete own loadouts']);
        // their companies'
        Permission::create(['name' => 'view own company loadouts']);
        Permission::create(['name' => 'create own company loadouts']);
        Permission::create(['name' => 'edit own company loadouts']);
        Permission::create(['name' => 'delete own company loadouts']);
        // their factions'
        Permission::create(['name' => 'view own faction loadouts']);
        Permission::create(['name' => 'create own faction loadouts']);
        Permission::create(['name' => 'edit own faction loadouts']);
        Permission::create(['name' => 'delete own faction loadouts']);
    // -- companies --
        // do all for their company
        Permission::create(['name' => 'govern company']);
        
        Permission::create(['name' => 'view companies']);
        Permission::create(['name' => 'create companies']);
        Permission::create(['name' => 'edit companies']);
        Permission::create(['name' => 'delete companies']);
        // their own
        Permission::create(['name' => 'view own companies']);
        Permission::create(['name' => 'create own companies']);
        Permission::create(['name' => 'edit own companies']);
        Permission::create(['name' => 'delete own companies']);
        // their factions'
        Permission::create(['name' => 'view own faction companies']);
        Permission::create(['name' => 'create own faction companies']);
        Permission::create(['name' => 'edit own faction companies']);
        Permission::create(['name' => 'delete own faction companies']);
    // -- rosters --
        Permission::create(['name' => 'view rosters']);
        Permission::create(['name' => 'create rosters']);
        Permission::create(['name' => 'edit rosters']);
        Permission::create(['name' => 'delete rosters']);
        // their own
        Permission::create(['name' => 'view own rosters']);
        Permission::create(['name' => 'create own rosters']);
        Permission::create(['name' => 'edit own rosters']);
        Permission::create(['name' => 'delete own rosters']);
        // their companies'
        Permission::create(['name' => 'view own company rosters']);
        Permission::create(['name' => 'create own company rosters']);
        Permission::create(['name' => 'edit own company rosters']);
        Permission::create(['name' => 'delete own company rosters']);
        // their factions'
        Permission::create(['name' => 'view own faction rosters']);
        Permission::create(['name' => 'create own faction rosters']);
        Permission::create(['name' => 'edit own faction rosters']);
        Permission::create(['name' => 'delete own faction rosters']);
        
    // -- events --
        Permission::create(['name' => 'view events']);
        Permission::create(['name' => 'create events']);
        Permission::create(['name' => 'edit events']);
        Permission::create(['name' => 'delete events']);
        // their own
        Permission::create(['name' => 'view own events']);
        Permission::create(['name' => 'create own events']);
        Permission::create(['name' => 'edit own events']);
        Permission::create(['name' => 'delete own events']);
        // their companies'
        Permission::create(['name' => 'view own company events']);
        Permission::create(['name' => 'create own company events']);
        Permission::create(['name' => 'edit own company events']);
        Permission::create(['name' => 'delete own company events']);
        // their factions'
        Permission::create(['name' => 'view own faction events']);
        Permission::create(['name' => 'create own faction events']);
        Permission::create(['name' => 'edit own faction events']);
        Permission::create(['name' => 'delete own faction events']);
        
    // -- users --
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);

        Permission::create(['name' => 'view own faction users']);
        Permission::create(['name' => 'view own company users']);
        Permission::create(['name' => 'edit users cosmetic info']);
        
        // ownership
        /*Permission::create(['name' => 'of all']);
        Permission::create(['name' => 'of their own']);
        Permission::create(['name' => 'of their company']);
        Permission::create(['name' => 'of their faction']);*/

        /*// create permissions
        Permission::create(['name' => 'do all']);
        Permission::create(['name' => 'view']);
        Permission::create(['name' => 'create']);
        Permission::create(['name' => 'edit']);
        Permission::create(['name' => 'delete']);
        // models
        Permission::create(['name' => 'characters']);
        Permission::create(['name' => 'loadouts']);
        Permission::create(['name' => 'companies']);
        Permission::create(['name' => 'rosters']);
        Permission::create(['name' => 'users']);
        // ownership
        Permission::create(['name' => 'for all']);
        Permission::create(['name' => 'of their company']);
        Permission::create(['name' => 'of their faction']);
        Permission::create(['name' => 'of their own']);*/

    }
}
