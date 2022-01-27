<?php

namespace Database\Seeders;

use App\Models\Companies\Company;
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
        
        // get roles from discord
        $companies = Company::select('discord_guild_id')->get();
        foreach($companies as $company){

            $response = Http::withHeaders([
                  "Authorization" => "Bot ".config('services.discord.bot_token')
              ])
            ->acceptJson()
            ->get("https://discord.com/api/guilds/{$company->discord_guild_id}/roles")
            ;

            //    dd($response->json());

            foreach($response->json() as $discord_role){
                if(isset($discord_role['tags']['bot_id'])){
                    // don't add bot roles
                    continue;
                }
                // team roles can have the same name on different teams
                $role = Role::updateOrCreate([
                    'name' => strtolower(Str::slug($discord_role['name'])),
                    'team_id' => $company->id,
                ]);

                DB::table('discord_roles')->upsert(
                    [
                        'id'=> $discord_role['id'],
                        'color'=> $discord_role['color'],
                        'icon'=> $discord_role['icon'],
                        'permissions'=> $discord_role['permissions'],
                        'company_id'=> $company->id,
                        'role_id' => $role->id,
                    ],
                    ['id'=> $discord_role['id']],
                );
            }
        }
    }
}
