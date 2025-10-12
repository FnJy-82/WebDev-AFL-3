<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Warehouse::create([
            'name' => 'Allstock Warehouse',
            'logo' => 'allstocklogo.png',
            'description' => 'Pusat distribusi dan penyimpanan produk batik dan sarung terpercaya di Surabaya, menghubungkan pengrajin lokal dengan pasar yang lebih luas melalui sistem logistik modern.',
            'vision' => 'Menjadi pusat distribusi dan penyimpanan terpercaya untuk produk batik dan sarung lokal, yang mendorong kemajuan industri tekstil tradisional Indonesia melalui efisiensi, kolaborasi, dan inovasi logistik.',
            'mission_1' => 'Memberdayakan pengrajin dan produsen kecil dari berbagai daerah untuk menjangkau pasar yang lebih luas.',
            'mission_2' => 'Menyediakan sistem penyimpanan dan distribusi yang efisien, modern, dan berlokasi strategis di Surabaya.',
            'mission_3' => 'Menjaga kualitas dan keaslian setiap produk sebagai wujud pelestarian warisan budaya Indonesia.',
            'address' => 'Jl. Raya Warehouse No. 123, Gedung Modern Lt. 3',
            'city' => 'Surabaya'
        ]);
    }
}
