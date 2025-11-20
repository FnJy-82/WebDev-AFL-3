<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed all tables for the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            WarehouseSeeder::class,
            CategorySeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class,
            StockInSeeder::class,
        ]);
    }
}
