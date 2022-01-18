<?php

namespace Database\Seeders;

use App\Models\Companies\EventType;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
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
            UserSeeder::class,
            FactionSeeder::class,
            CompanySeeder::class,
            ClassTypeSeeder::class,
            SkillTypeSeeder::class,
            RankSeeder::class,
            ClassSeeder::class,
            SkillSeeder::class,
            AttributeSeeder::class,
//            ConsumableSeeder::class,
//            BaseArmorSeeder::class,
//            BaseWeaponSeeder::class,
//            PerkSeeder::class,
            AttributeSeeder::class,
        ]);
    }
}
