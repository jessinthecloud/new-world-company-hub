<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // create roles and assign existing permissions

        // super admin gets all permissions via Gate::before rule; see AuthServiceProvider
        $super = Role::updateOrCreate(['name' => 'super-admin']);
        $admin = Role::updateOrCreate(['name' => 'admin']);
        
        // get roles from breakpoint discord
        $response = Http::withHeaders([
            "Authorization" => "Bot ".config('services.discord.bot_token')
        ])
        ->acceptJson()
        ->get("https://discord.com/api/guilds/895006799319666718/roles")
        ;
        
    //    dd($response->json());
        
        foreach($response->json() as $discord_role){
            if(isset($discord_role['tags']['bot_id'])){
                // don't add bot roles
                continue;
            }
            $role = Role::updateOrCreate(['name' => strtolower(Str::slug($discord_role['name']))]);
            
            DB::table('discord_roles')->upsert(
                [
                    'id'=> $discord_role['id'],
                    'color'=> $discord_role['color'],
                    'icon'=> $discord_role['icon'],
                    'permissions'=> $discord_role['permissions'],
                    'company_id'=> 1, // breakpoint
                    'role_id' => $role->id,
                ],
                ['id'=> $discord_role['id']], 
            );
        }
    }
}
