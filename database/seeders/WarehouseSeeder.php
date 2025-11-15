<?php

// namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;
// use App\Models\Warehouse;

// class WarehouseSeeder extends Seeder
// {
//     /**
//      * Run the database seeds.
//      */

//     // public function run(): void
//     // {
//     //     Warehouse::create([
//     //         'name' => 'AllStock Warehouse',
//     //         'logo' => 'warehouselogo.jpg',
//     //         'description' => 'Allstock Warehouse adalah pusat distribusi dan penyimpanan yang berfokus pada produk pakaian batik, dengan spesialisasi utama pada sarung. Seluruh produk kami berasal dari berbagai kota kecil di Indonesia dan dikurasi dengan kualitas terbaik sebelum disimpan di gudang kami yang berlokasi strategis di Surabaya. Sebagai jembatan antara produsen lokal dan pasar yang lebih luas, Allstock Warehouse bekerja sama dengan berbagai seller untuk memastikan ketersediaan produk, efisiensi distribusi, serta mendukung pertumbuhan ekonomi pengrajin daerah.',
//     //         'vision' => 'Menjadi pusat distribusi dan penyimpanan terpercaya untuk produk batik dan sarung lokal, yang mendorong kemajuan industri tekstil tradisional Indonesia melalui efisiensi, kolaborasi, dan inovasi logistik.',
//     //         'mission_1' => 'Memberdayakan pengrajin dan produsen kecil dari berbagai daerah untuk menjangkau pasar yang lebih luas.',
//     //         'mission_2' => 'Menyediakan sistem penyimpanan dan distribusi yang efisien, modern, dan berlokasi strategis di Surabaya.',
//     //         'mission_3' => 'Menjalin kemitraan berkelanjutan dengan para seller untuk memperkuat rantai pasok produk batik dan sarung.',
//     //         'mission_4' => 'Menjaga kualitas dan keaslian setiap produk sebagai wujud pelestarian warisan budaya Indonesia.',
//     //         'address' => 'Jl. Demak no. 186',
//     //         'city' => 'Surabaya'
//     //     ]);
//     // }
// }

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        Warehouse::create([
            'name' => 'Allstock Warehouse Surabaya',
            'code' => 'WH-SBY-001',
            'address' => 'Jl. Demak no. 186',
            'city' => 'Surabaya',
            'province' => 'Jawa Timur',
            'postal_code' => '60123',
            'manager_name' => 'Budi Santoso',
            'phone' => '031-1234567',
            'capacity' => 10000,
            'is_active' => true,
        ]);
    }
}
