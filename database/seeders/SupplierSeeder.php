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
                'name' => 'ATHYA BATIK',
                'shopee_link' => 'https://s.shopee.co.id/7pkZRDTG6j?share_channel_code=1'
            ],
            [
                'name' => 'ALFAZ BATIK',
                'shopee_link' => 'https://s.shopee.co.id/4LAhGqixEM?share_channel_code=1' 
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }

        $this->command->info('✅ 2 supplier berhasil ditambahkan!');
    }
}