<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Seni Tari',
                'slug'=> 'seni-tari',
                'description' => 'Berbagai macam pelatihan tarian tradisional dan modern',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Seni Musik',
                'slug'=> 'seni-musik',
                'description' => 'Pelatihan alat musik tradisional dan kontemporer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Seni Rupa',
                'slug'=>'seni-rupa',
                'description' => 'Pelatihan lukis, patung, dan kerajinan tangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Seni Teater',
                'slug'=> 'seni-teater',
                'description' => 'Pelatihan akting dan pertunjukan teater',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Seni Vokal',
                'slug'=> 'seni-vokal',
                'description' => 'Pelatihan menyanyi dan olah vokal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];



        Category::insert($categories);
    }
}
