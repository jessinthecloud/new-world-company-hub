<?php

namespace Database\Seeders;


use App\Models\Events\EventType;
use Illuminate\Database\Seeder;

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
        EventType::upsert([[
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
        ]], ['slug']);

        $this->call([
            PermissionSeeder::class,
            FactionSeeder::class,
            CompanySeeder::class,
            RoleSeeder::class,
            RolePermissionSeeder::class,
            ClassTypeSeeder::class,
            SkillTypeSeeder::class,
            RankSeeder::class,
            ClassSeeder::class,
            SkillSeeder::class,
            TiersSeeder::class,
            PrefixesSeeder::class,
            SuffixesSeeder::class,
            ItemTypesSeeder::class,
            ItemSubtypesSeeder::class,
            PerkTypeSeeder::class,
            PerkSeeder::class,
            BaseItemSeeder::class,
            UserSeeder::class,
//            WeaponSeeder::class,
//            ArmorSeeder::class,
        ]);
    }
}
