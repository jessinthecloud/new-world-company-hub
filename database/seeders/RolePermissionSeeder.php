<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $all_roles = Role::all(); 
    // -- ADMIN
        $admin = $all_roles->where('name', '=', 'super-admin')->first();
        $admin->givePermissionTo(
            'view characters', 'create characters', 'edit characters', 
            'view loadouts', 'create loadouts', 'edit loadouts', 
            'view companies', 'create companies', 'edit companies', 
            'view rosters', 'create rosters', 'edit rosters', 'import rosters',
            'view events', 'create events', 'edit events',
            'view positions', 'create positions', 'edit positions',
            'view users', 'edit users cosmetic info',
            'view guildbanks', 'create guildbanks', 'edit guildbanks',
        );
    // -- BANKER
        $banker = $all_roles->where('name', '=', 'banker')->first();
        $banker->givePermissionTo(
            'view own company guildbanks',
            'create own company guildbanks',
            'edit own company guildbanks',
            'delete own company guildbanks',
        );
    // -- GOVERNOR
        $governor = $all_roles->where('name', '=', 'governor')->first();
        if(!empty($governor)) {
            $governor->givePermissionTo(
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
                'view own company characters',

                'view own company guildbanks',

                'view own company rosters',
                'create own company rosters',
                'import own company rosters',
                'edit own company rosters',

                'view own company loadouts',

                'view own company events',
                'create own company events',
                'edit own company events',

                'view own company positions',
                'create own company positions',
                'edit own company positions',

                // -- faction permissions
                'view own faction companies',
                'view own faction rosters',
                'view own faction events',
                'view own faction positions',
                'view own faction users',
                'view own faction characters',
                'view own faction loadouts',
            );
        }
    // -- CONSUL
        $consul = $all_roles->where('name', '=', 'consul')->first();
        $consul->givePermissionTo(
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
            'import own company rosters',
            'edit own company rosters',
            
            'view own company characters',
            'view own company loadouts',
            
            'view own company guildbanks',
            
            'view own company events', 
            'create own company events', 
            'edit own company events',
            
            'view own company positions', 
            'create own company positions', 
            'edit own company positions',

        // -- faction permissions
            'view own faction companies',
            'view own faction events',
            'view own faction characters',
        );
    // -- OFFICER
        $officer = $all_roles->where('name', '=', 'officer')->first();
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
    
    // -- company permissions
            'view own company rosters', 
            'create own company rosters', 
            'edit own company rosters',
            'import own company rosters',
            
            'view own company users',
            'view own company characters',
            'view own company loadouts',
            
            'view own company guildbanks',
            
            'view own company events', 
            'create own company events', 
            'edit own company events',
            
            'view own company positions', 
            'create own company positions', 
            'edit own company positions',

    // -- faction permissions
            'view own faction companies',
        );
    // -- MEMBER
        $member = $all_roles->where('name', '=', 'breakpoint-member')->first();
        $member->givePermissionTo(
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
            'view own company guildbanks',
            'view own rosters',
        );
    }
}
