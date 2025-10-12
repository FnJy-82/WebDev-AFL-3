<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        $suppliers = [
            [
                'name' => 'Batik Pekalongan Indah',
                'shopee_link' => 'https://shopee.co.id/batikpekalonganindah'
            ],
            [
                'name' => 'Sarung Solo Berkualitas',
                'shopee_link' => 'https://shopee.co.id/sarungsoloberkualitas' 
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        $this->command->info('✅ 2 supplier berhasil ditambahkan!');
    }
}