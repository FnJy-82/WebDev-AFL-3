<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::create([
            'name' => 'ATHYA BATIK',
            'slug' => 'athya-batik',
            'shopee_link' => 'https://s.shopee.co.id/7pkZRDTG6j?share_channel_code=1',
            'contact_person' => 'Ibu Athya',
            'phone' => '081234567892',
            'email' => 'athya@batik.com',
            'address' => 'Jl. Batik No. 123',
            'city' => 'Solo',
            'is_active' => true,
        ]);

        Supplier::create([
            'name' => 'ALFAZ BATIK',
            'slug' => 'alfaz-batik',
            'shopee_link' => 'https://s.shopee.co.id/4LAhGqixEM?share_channel_code=1',
            'contact_person' => 'Pak Alfaz',
            'phone' => '081234567893',
            'email' => 'alfaz@batik.com',
            'address' => 'Jl. Textile No. 456',
            'city' => 'Pekalongan',
            'is_active' => true,
        ]);
    }
}
