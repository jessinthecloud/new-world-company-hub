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
        Permission::create(['name' => 'do all']);
        Permission::create(['name' => 'view all']);
        Permission::create(['name' => 'create all']);
        Permission::create(['name' => 'edit all']);
        Permission::create(['name' => 'delete all']);
        // characters
        Permission::create(['name' => 'view characters']);
        Permission::create(['name' => 'create characters']);
        Permission::create(['name' => 'edit characters']);
        Permission::create(['name' => 'delete characters']);
        // loadouts
        Permission::create(['name' => 'view loadouts']);
        Permission::create(['name' => 'create loadouts']);
        Permission::create(['name' => 'edit loadouts']);
        Permission::create(['name' => 'delete loadouts']);
        // companies
        Permission::create(['name' => 'view companies']);
        Permission::create(['name' => 'create companies']);
        Permission::create(['name' => 'edit companies']);
        Permission::create(['name' => 'delete companies']);
        // rosters
        Permission::create(['name' => 'view rosters']);
        Permission::create(['name' => 'create rosters']);
        Permission::create(['name' => 'edit rosters']);
        Permission::create(['name' => 'delete rosters']);
        // users
        Permission::create(['name' => 'view users']);
        Permission::create(['name' => 'create users']);
        Permission::create(['name' => 'edit users']);
        Permission::create(['name' => 'delete users']);
        
        // ownership
        Permission::create(['name' => 'of all']);
        Permission::create(['name' => 'of their company']);
        Permission::create(['name' => 'of their faction']);
        Permission::create(['name' => 'of their own']);

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
