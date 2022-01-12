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

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            FactionSeeder::class,
            CompanySeeder::class,
            ClassTypeSeeder::class,
            SkillTypeSeeder::class,
            RankSeeder::class,
            ClassSeeder::class,
            SkillSeeder::class,
            AttributeSeeder::class,
            BaseWeaponSeeder::class,
            BaseArmorSeeder::class,
            PerkSeeder::class,
//            ConsumableSeeder::class,
//            LoadoutSeeder::class,
            CharacterSeeder::class,
            UserSeeder::class,
            GuildBankSeeder::class,
        ]);
    }
}
