<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // create roles and assign existing permissions

        // super admin gets all permissions via Gate::before rule; see AuthServiceProvider
        $role1 = Role::create(['name' => 'super-admin']);
        $role1->givePermissionTo(
            'view characters', 'create characters', 'edit characters', 'delete characters', 
            'view loadouts', 'create loadouts', 'edit loadouts', 'delete loadouts',
            'view companies', 'create companies', 'edit companies', 'delete companies', 
            'view rosters', 'create rosters', 'edit rosters', 'delete rosters',
            'view events', 'create events', 'edit events', 'delete events',
            'view positions', 'create positions', 'edit positions', 'delete positions',
            'view users', 'create users', 'edit users', 'delete users'
        );

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(
            'view characters', 'create characters', 'edit characters', 
            'view loadouts', 'create loadouts', 'edit loadouts', 
            'view companies', 'create companies', 'edit companies', 
            'view rosters', 'create rosters', 'edit rosters',
            'view events', 'create events', 'edit events',
            'view positions', 'create positions', 'edit positions',
            'view users', 'edit users cosmetic info'
        );

        $governor = Role::create(['name' => 'governor']);
        $governor->givePermissionTo(
            
            'govern company',
            
        // -- own permissions
            'view own characters',
            'create own characters',
            'edit own characters',
            'delete own characters',
            
            'view own loadouts',
            'create own loadouts',
            'edit own loadouts',
            'delete own loadouts',
            
            'view own companies',
            'edit own companies',
            
            'view own faction companies',
            'view own rosters',
            'view own company rosters',

        // -- company permissions
            'view own company users',
            'view own company rosters',
            'create own company rosters',
            'edit own company rosters',
            'view own company characters',
            'view own company loadouts',
            'view own company events', 'create own company events', 'edit own company events',
            'view own company positions', 'create own company positions', 'edit own company positions',

        // -- faction permissions
            'view own faction companies',
            'view own faction rosters',
            'view own faction events',
            'view own faction positions',
            'view own faction users',
            'view own faction characters',
            'view own faction loadouts',
        );
        
        $officer = Role::create(['name' => 'officer']);
        $officer->givePermissionTo(
        
        // -- own permissions
            'view own characters',
            'create own characters',
            'edit own characters',
            'delete own characters',
    
            'view own loadouts',
            'create own loadouts',
            'edit own loadouts',
            'delete own loadouts',
    
            'view own companies',
            'view own rosters',
            
            'view own company rosters', 'create own company rosters', 'edit own company rosters',
            'view own company events', 'create own company events', 'edit own company events',
            'view own company positions', 'create own company positions', 'edit own company positions',
            
            'view own faction companies',
    
        // -- company permissions
            'view own company users',
            'view own company rosters',
            'create own company rosters',
            'edit own company rosters',
            'view own company characters',
            'view own company loadouts',
    
        // -- faction permissions

        );
        
        $settler = Role::create(['name' => 'settler']);
        $settler->givePermissionTo(
            // -- own permissions
            'view own characters',
            'create own characters',
            'edit own characters',
            'delete own characters',
    
            'view own loadouts',
            'create own loadouts',
            'edit own loadouts',
            'delete own loadouts',
    
            'view own companies',
    
            'view own faction companies',
            'view own company rosters',
            'view own rosters',
        );
        
        $user = Role::create(['name' => 'user']);
        $user->givePermissionTo(
            // -- own permissions
            'view own characters',
            'create own characters',
            'edit own characters',
            'delete own characters',
    
            'view own loadouts',
            'create own loadouts',
            'edit own loadouts',
            'delete own loadouts',
    
            'view own companies',
            'view own rosters',
        );
        
        /*DB::table('roles')->insert([
            [
                'name' => 'Super Admin',
                'guard_name' => 'Super Admin',
                'team_id' => 0,
                'created_at' => now(), 
                'updated_at' => now(),
            ],
            [
                'name' => 'Company Governor',
                'guard_name' => 'Company Governor',
                'team_id' => 1, //Company::where('id', 1)->first(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Company Officer',
                'guard_name' => 'Company Officer',
                'team_id' => 1, //Company::where('id', 1)->first(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Company Settler',
                'guard_name' => 'Company Settler',
                'team_id' => 1, //Company::where('id', 1)->first(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Player',
                'guard_name' => 'Player',
                'team_id' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);*/
    }
}
