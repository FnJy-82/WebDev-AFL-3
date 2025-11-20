<?php

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
            'manager_name' => 'Celine',
            'phone' => '031-1234567',
            'capacity' => 10000,
            'is_active' => true,
        ]);
    }
}
