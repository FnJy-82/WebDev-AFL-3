<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Sarung Batik Printing Pria',
                'slug' => 'sarung-batik-printing-pria',
                'description' => 'Sarung batik printing untuk pria dengan berbagai motif',
                'icon' => '👔',
                'is_active' => true,
            ],
            [
                'name' => 'Sarung Santriwati Wanita',
                'slug' => 'sarung-santriwati-wanita',
                'description' => 'Sarung khusus untuk santriwati dengan motif elegan',
                'icon' => '👗',
                'is_active' => true,
            ],
            [
                'name' => 'Sarung Batik Cap Halus',
                'slug' => 'sarung-batik-cap-halus',
                'description' => 'Sarung batik cap dengan kualitas halus',
                'icon' => '🎨',
                'is_active' => true,
            ],
            [
                'name' => 'Sarung Wanita Goyor Cap',
                'slug' => 'sarung-wanita-goyor-cap',
                'description' => 'Sarung goyor cap untuk wanita',
                'icon' => '💃',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
