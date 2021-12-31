<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        
// -- faction --
        // all
        Permission::create(['name' => 'view faction']);
        Permission::create(['name' => 'create faction']);
        Permission::create(['name' => 'edit faction']);
        Permission::create(['name' => 'delete faction']);
        // their own
        Permission::create(['name' => 'view own faction']);
        Permission::create(['name' => 'create own faction']);
        Permission::create(['name' => 'edit own faction']);
        Permission::create(['name' => 'delete own faction']);
        
    // -- characters --
        // all
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
        // all
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
        // all
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
        // all
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
        // all
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

// -- positions --
        // all
        Permission::create(['name' => 'view positions']);
        Permission::create(['name' => 'create positions']);
        Permission::create(['name' => 'edit positions']);
        Permission::create(['name' => 'delete positions']);
        // their own
        Permission::create(['name' => 'view own positions']);
        Permission::create(['name' => 'create own positions']);
        Permission::create(['name' => 'edit own positions']);
        Permission::create(['name' => 'delete own positions']);
        // their companies'
        Permission::create(['name' => 'view own company positions']);
        Permission::create(['name' => 'create own company positions']);
        Permission::create(['name' => 'edit own company positions']);
        Permission::create(['name' => 'delete own company positions']);
        // their factions'
        Permission::create(['name' => 'view own faction positions']);
        Permission::create(['name' => 'create own faction positions']);
        Permission::create(['name' => 'edit own faction positions']);
        Permission::create(['name' => 'delete own faction positions']);
        
    // -- users --
        // all
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        // misc
        Permission::create(['name' => 'view own faction users']);
        Permission::create(['name' => 'view own company users']);
        Permission::create(['name' => 'edit users cosmetic info']);
    }
}
