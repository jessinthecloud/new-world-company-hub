<?php

namespace Database\Seeders;

use App\Enums\AttributeType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        $types = AttributeType::cases();
        $insert = [];
        foreach($types as $type){
            $insert []= [
                'name' => $type,
                'slug' => Str::slug($type->value),
            ];
        }
        DB::table('attributes')->insert($insert);
    }
}
