<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShippingPartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $partners = [
            [
                'name' => 'JNE Express',
                'logo' => 'jneexpresslogo.png', // PASTI ADA!
                'service_type' => 'Express Delivery',
                'delivery_coverage' => 'Seluruh Indonesia,International'
            ],
            [
                'name' => 'SPX Express',
                'logo' => 'spxexpresslogo.png', // PASTI ADA!
                'service_type' => 'Cargo Service',
                'delivery_coverage' => 'Jawa,Bali,Sumatra,Kalimantan'
            ],
            [
                'name' => 'SiCepat',
                'logo' => 'sicepat.png', // PASTI ADA!
                'service_type' => 'Regular Delivery',
                'delivery_coverage' => 'Jabodetabek,Jawa Timur,Jawa Barat'
            ]
        ];
    }
}
