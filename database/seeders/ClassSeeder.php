<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassSeeder extends Seeder
{
    public function run()
    {
        DB::table('character_classes')->insert([
           [
               'name' => 'Mage',
               'description' => 'Healer Mage',
               'class_type_id' => 1,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Mage',
               'description' => 'Battle Mage',
               'class_type_id' => 2,
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Warrior',
               'description' => '',
               'class_type_id' => 2,
               'created_at' => now(),
               'updated_at' => now(),
           ],
       ]);
    }
}
