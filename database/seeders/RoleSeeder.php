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
        $role1->givePermissionTo('do all', 'for all');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('view characters', 'create characters', 'edit characters', 'view loadouts', 'create loadouts', 'edit loadouts', 'view companies', 'create companies', 'edit companies', 'view rosters', 'create rosters', 'edit rosters', 'view users', 'create users', 'edit users');

        $role3 = Role::create(['name' => 'governor']);
        $role3 = Role::create(['name' => 'officer']);
        $role3 = Role::create(['name' => 'settler']);
        $role3 = Role::create(['name' => 'player']);
        
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
