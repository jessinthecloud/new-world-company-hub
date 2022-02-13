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
        Permission::updateOrCreate(['name' => 'view faction']);
        Permission::updateOrCreate(['name' => 'create faction']);
        Permission::updateOrCreate(['name' => 'edit faction']);
        Permission::updateOrCreate(['name' => 'delete faction']);
        // their own
        Permission::updateOrCreate(['name' => 'view own faction']);
        Permission::updateOrCreate(['name' => 'create own faction']);
        Permission::updateOrCreate(['name' => 'edit own faction']);
        Permission::updateOrCreate(['name' => 'delete own faction']);
        
// -- companies --
        // all
        Permission::updateOrCreate(['name' => 'view companies']);
        Permission::updateOrCreate(['name' => 'create companies']);
        Permission::updateOrCreate(['name' => 'edit companies']);
        Permission::updateOrCreate(['name' => 'delete companies']);
        Permission::updateOrCreate(['name' => 'view company members']);
        Permission::updateOrCreate(['name' => 'create company members']);
        Permission::updateOrCreate(['name' => 'edit company members']);
        Permission::updateOrCreate(['name' => 'remove company members']);
        // their own
        Permission::updateOrCreate(['name' => 'view own companies']);
        Permission::updateOrCreate(['name' => 'edit own companies']);
        Permission::updateOrCreate(['name' => 'delete own companies']);
        Permission::updateOrCreate(['name' => 'view own company members']);
        Permission::updateOrCreate(['name' => 'create own company members']);
        Permission::updateOrCreate(['name' => 'edit own company members']);
        Permission::updateOrCreate(['name' => 'remove own company members']);
        // their factions'
        Permission::updateOrCreate(['name' => 'view own faction companies']);
        Permission::updateOrCreate(['name' => 'create own faction companies']);
        Permission::updateOrCreate(['name' => 'edit own faction companies']);
        Permission::updateOrCreate(['name' => 'delete own faction companies']);
        
// -- guild bank --
        // all
        Permission::updateOrCreate(['name' => 'view guildbanks']);
        Permission::updateOrCreate(['name' => 'create guildbanks']);
        Permission::updateOrCreate(['name' => 'edit guildbanks']);
        Permission::updateOrCreate(['name' => 'delete guildbanks']);
        // their company's
        Permission::updateOrCreate(['name' => 'view own company guildbanks']);
        Permission::updateOrCreate(['name' => 'create own company guildbanks']);
        Permission::updateOrCreate(['name' => 'edit own company guildbanks']);
        Permission::updateOrCreate(['name' => 'delete own company guildbanks']);
        // their factions'
        Permission::updateOrCreate(['name' => 'view own faction guildbanks']);
        Permission::updateOrCreate(['name' => 'create own faction guildbanks']);
        Permission::updateOrCreate(['name' => 'edit own faction guildbanks']);
        Permission::updateOrCreate(['name' => 'delete own faction guildbanks']);
        
    // -- characters --
        // all
        Permission::updateOrCreate(['name' => 'view characters']);
        Permission::updateOrCreate(['name' => 'create characters']);
        Permission::updateOrCreate(['name' => 'edit characters']);
        Permission::updateOrCreate(['name' => 'delete characters']);
        // their own
        Permission::updateOrCreate(['name' => 'view own characters']);
        Permission::updateOrCreate(['name' => 'create own characters']);
        Permission::updateOrCreate(['name' => 'edit own characters']);
        Permission::updateOrCreate(['name' => 'delete own characters']);
        // their companies'
        Permission::updateOrCreate(['name' => 'view own company characters']);
        Permission::updateOrCreate(['name' => 'create own company characters']);
        Permission::updateOrCreate(['name' => 'edit own company characters']);
        Permission::updateOrCreate(['name' => 'delete own company characters']);
        // their factions'
        Permission::updateOrCreate(['name' => 'view own faction characters']);
        Permission::updateOrCreate(['name' => 'create own faction characters']);
        Permission::updateOrCreate(['name' => 'edit own faction characters']);
        Permission::updateOrCreate(['name' => 'delete own faction characters']);
        
    // -- loadouts --
        // all
        Permission::updateOrCreate(['name' => 'view loadouts']);
        Permission::updateOrCreate(['name' => 'create loadouts']);
        Permission::updateOrCreate(['name' => 'edit loadouts']);
        Permission::updateOrCreate(['name' => 'delete loadouts']);
        Permission::updateOrCreate(['name' => 'approve loadouts']);
        // their own
        Permission::updateOrCreate(['name' => 'view own loadouts']);
        Permission::updateOrCreate(['name' => 'create own loadouts']);
        Permission::updateOrCreate(['name' => 'edit own loadouts']);
        Permission::updateOrCreate(['name' => 'delete own loadouts']);
        // their companies'
        Permission::updateOrCreate(['name' => 'view own company loadouts']);
        Permission::updateOrCreate(['name' => 'create own company loadouts']);
        Permission::updateOrCreate(['name' => 'edit own company loadouts']);
        Permission::updateOrCreate(['name' => 'delete own company loadouts']);
        Permission::updateOrCreate(['name' => 'approve own company loadouts']);
        // their factions'
        Permission::updateOrCreate(['name' => 'view own faction loadouts']);
        Permission::updateOrCreate(['name' => 'create own faction loadouts']);
        Permission::updateOrCreate(['name' => 'edit own faction loadouts']);
        Permission::updateOrCreate(['name' => 'delete own faction loadouts']);
        Permission::updateOrCreate(['name' => 'approve own faction loadouts']);

    // -- rosters --
        // all
        Permission::updateOrCreate(['name' => 'view rosters']);
        Permission::updateOrCreate(['name' => 'create rosters']);
        Permission::updateOrCreate(['name' => 'edit rosters']);
        Permission::updateOrCreate(['name' => 'delete rosters']);
        Permission::updateOrCreate(['name' => 'import company rosters']);
        Permission::updateOrCreate(['name' => 'export company rosters']);
        // their own
        Permission::updateOrCreate(['name' => 'view own rosters']);
        Permission::updateOrCreate(['name' => 'edit own rosters']);
        Permission::updateOrCreate(['name' => 'delete own rosters']);
        // their companies'
        Permission::updateOrCreate(['name' => 'view own company rosters']);
        Permission::updateOrCreate(['name' => 'create own company rosters']);
        Permission::updateOrCreate(['name' => 'edit own company rosters']);
        Permission::updateOrCreate(['name' => 'delete own company rosters']);
        Permission::updateOrCreate(['name' => 'import own company rosters']);
        Permission::updateOrCreate(['name' => 'export own company rosters']);
        // their factions'
        Permission::updateOrCreate(['name' => 'view own faction rosters']);
        Permission::updateOrCreate(['name' => 'create own faction rosters']);
        Permission::updateOrCreate(['name' => 'edit own faction rosters']);
        Permission::updateOrCreate(['name' => 'delete own faction rosters']);
        Permission::updateOrCreate(['name' => 'import own faction rosters']);
        Permission::updateOrCreate(['name' => 'export own faction rosters']);
    // -- events --
        // all
        Permission::updateOrCreate(['name' => 'view events']);
        Permission::updateOrCreate(['name' => 'create events']);
        Permission::updateOrCreate(['name' => 'edit events']);
        Permission::updateOrCreate(['name' => 'delete events']);
        // their own
        Permission::updateOrCreate(['name' => 'view own events']);
        Permission::updateOrCreate(['name' => 'create own events']);
        Permission::updateOrCreate(['name' => 'edit own events']);
        Permission::updateOrCreate(['name' => 'delete own events']);
        // their companies'
        Permission::updateOrCreate(['name' => 'view own company events']);
        Permission::updateOrCreate(['name' => 'create own company events']);
        Permission::updateOrCreate(['name' => 'edit own company events']);
        Permission::updateOrCreate(['name' => 'delete own company events']);
        // their factions'
        Permission::updateOrCreate(['name' => 'view own faction events']);
        Permission::updateOrCreate(['name' => 'create own faction events']);
        Permission::updateOrCreate(['name' => 'edit own faction events']);
        Permission::updateOrCreate(['name' => 'delete own faction events']);

// -- positions --
        // all
        Permission::updateOrCreate(['name' => 'view positions']);
        Permission::updateOrCreate(['name' => 'create positions']);
        Permission::updateOrCreate(['name' => 'edit positions']);
        Permission::updateOrCreate(['name' => 'delete positions']);
        // their own
        Permission::updateOrCreate(['name' => 'view own positions']);
        Permission::updateOrCreate(['name' => 'create own positions']);
        Permission::updateOrCreate(['name' => 'edit own positions']);
        Permission::updateOrCreate(['name' => 'delete own positions']);
        // their companies'
        Permission::updateOrCreate(['name' => 'view own company positions']);
        Permission::updateOrCreate(['name' => 'create own company positions']);
        Permission::updateOrCreate(['name' => 'edit own company positions']);
        Permission::updateOrCreate(['name' => 'delete own company positions']);
        // their factions'
        Permission::updateOrCreate(['name' => 'view own faction positions']);
        Permission::updateOrCreate(['name' => 'create own faction positions']);
        Permission::updateOrCreate(['name' => 'edit own faction positions']);
        Permission::updateOrCreate(['name' => 'delete own faction positions']);
        
    // -- users --
        // all
        Permission::updateOrCreate(['name' => 'view users']);
        Permission::updateOrCreate(['name' => 'create users']);
        Permission::updateOrCreate(['name' => 'edit users']);
        Permission::updateOrCreate(['name' => 'delete users']);
        // misc
        Permission::updateOrCreate(['name' => 'view own faction users']);
        Permission::updateOrCreate(['name' => 'view own company users']);
        Permission::updateOrCreate(['name' => 'edit users cosmetic info']);
      
    // -- company members
        // all 
        Permission::updateOrCreate(['name' => 'export company members']);
        // their companies'
        Permission::updateOrCreate(['name' => 'export own company members']);
        // their factions'
        Permission::updateOrCreate(['name' => 'export own faction company members']);
        
    // -- miscellaneous
        

    }
}
