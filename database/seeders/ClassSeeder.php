<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    public function run()
    {
        DB::table('character_classes')->upsert([
           /*[
               'name' => 'Mage',
               'description' => 'Healer Mage',
               'character_class_type_id' => 1,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Mage',
               'description' => 'Battle Mage',
               'character_class_type_id' => 2,
               'created_at' => now(),
               'updated_at' => now(),
           ],*/
           [
               'name' => 'Mage',
               'description' => '',
               'character_class_type_id' => 1,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Healer',
               'description' => '',
               'character_class_type_id' => 1,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Tank',
               'description' => '',
               'character_class_type_id' => 1,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Melee',
               'description' => '',
               'character_class_type_id' => 1,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Ranged',
               'description' => '',
               'character_class_type_id' => 1,
               'created_at' => now(),
               'updated_at' => now(),
           ],
       ], ['name']);
    }
}
