<?php

namespace Database\Seeders;


use App\Models\Character;
use App\Models\CharacterClass;
use App\Models\Company;
use App\Models\EventType;
use App\Models\Rank;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
            'slug' => 'war',
            'description' => '',
        ], [
            'name' => 'Invasion',
            'slug' => 'invasion',
            'description' => '',
        ], [
            'name' => 'Chest Run',
            'slug' => 'chest-run',
            'description' => '',
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
//            CharacterSeeder::class,
            WeaponTypeSeeder::class,
            WeaponSeeder::class,
            ArmorSeeder::class,
//            LoadoutSeeder::class,
        ]);
        
        // create Faction entries and override with default values
        $governor = \App\Models\User::factory()
            ->create([
                'name' => 'Govna',
                'email' => 'test@test.com',
                'password' => Hash::make('password'),
                'remember_token' => null,
            ]);
            
        $govchar = Character::factory()
            // don't need state because seeder has these set
            ->state(new Sequence(
                    fn ($sequence) => [
                        'character_class_id' => CharacterClass::all()->random(),
                        'rank_id' => 1,
                        'company_id' => 1,
                    ],
                )
            )
            ->hasAttached(
                Skill::all()->random(Skill::count()),
                ['level' => abs(rand(0,100))],
            )
            ->create();
            
        $govchar->user()->associate($governor);
        $govchar->save();
        $governor->assignRole('governor');
    }
}
