<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('character_class_types')->insert([
           [
               'name' => 'Healer',
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'DPS',
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
           [
               'name' => 'Tank',
               'description' => '',
               'created_at' => now(),
               'updated_at' => now(),
           ],
       ]);
    }
}
