<?php

namespace Database\Seeders;


use App\Models\EventType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);
        
        // create Faction entries and override with default values
         $user = \App\Models\User::factory()
             /*->hasAttached(
                 Role::where('name', '=', 'super-admin')->first(),
                 ['team_id' => 0,]
             )*/
            ->create([
                'name' => 'Jess',
                'email' => 'epwnaz@gmail.com',
                'password' => Hash::make('password'),
                'remember_token' => null,
            ]);
            
        $user->assignRole('super-admin');
        
        // event types 
        EventType::create([
            'name' => 'War',
//            'description' => '',
        ], [
            'name' => 'Invasion',
        //            'description' => '',
        ]);
        
        // run other seeders
        $this->call([
            FactionSeeder::class,
            CompanySeeder::class,
            ClassTypeSeeder::class,
            SkillTypeSeeder::class,
            ClassSeeder::class,
            SkillSeeder::class,
            RankSeeder::class,
            CharacterSeeder::class,
            WeaponTypeSeeder::class,
            WeaponSeeder::class,
            LoadoutSeeder::class,
        ]);
    }
}
