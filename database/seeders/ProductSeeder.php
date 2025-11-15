<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $warehouse = Warehouse::first();
        $suppliers = Supplier::all();

        // SARUNG BATIK PRINTING PRIA
        $category1 = Category::where('slug', 'sarung-batik-printing-pria')->first();
        $products1 = [
            ['name' => 'Balimun Hitam', 'stock' => 14, 'pattern' => 'Balimun', 'color' => 'Hitam'],
            ['name' => 'Balimun Putih', 'stock' => 13, 'pattern' => 'Balimun', 'color' => 'Putih'],
            ['name' => 'Pagar Alam Coksu', 'stock' => 5, 'pattern' => 'Pagar Alam', 'color' => 'Coklat Susu'],
            ['name' => 'Pagar Alam Hitam', 'stock' => 17, 'pattern' => 'Pagar Alam', 'color' => 'Hitam'],
            ['name' => 'Sarwon Abu', 'stock' => 6, 'pattern' => 'Sarwon', 'color' => 'Abu-abu'],
            ['name' => 'Sarwon Hitam', 'stock' => 8, 'pattern' => 'Sarwon', 'color' => 'Hitam'],
        ];

        foreach ($products1 as $p) {
            $product = Product::create([
                'category_id' => $category1->id,
                'warehouse_id' => $warehouse->id,
                'name' => $p['name'],
                'description' => 'Sarung batik printing pria motif ' . $p['pattern'],
                'purchase_price' => rand(50000, 80000),
                'selling_price' => rand(80000, 120000),
                'current_stock' => $p['stock'],
                'minimum_stock' => 5,
                'unit' => 'pcs',
                'color' => $p['color'],
                'pattern' => $p['pattern'],
                'is_active' => true,
            ]);
            $product->suppliers()->attach($suppliers->random()->id, ['is_primary' => true]);
        }

        // SARUNG SANTRIWATI WANITA
        $category2 = Category::where('slug', 'sarung-santriwati-wanita')->first();
        $products2 = [
            ['name' => 'MTK', 'stock' => 8],
            ['name' => 'Tumpal', 'stock' => 0],
            ['name' => 'Beras', 'stock' => 1],
            ['name' => 'Kupu Ilalang', 'stock' => 0],
            ['name' => 'Lotus Coksu', 'stock' => 0],
            ['name' => 'Mahkota', 'stock' => 0],
            ['name' => 'Neng Santri', 'stock' => 9],
            ['name' => 'Kenangan', 'stock' => 1],
        ];

        foreach ($products2 as $p) {
            $product = Product::create([
                'category_id' => $category2->id,
                'warehouse_id' => $warehouse->id,
                'name' => $p['name'],
                'description' => 'Sarung santriwati motif ' . $p['name'],
                'purchase_price' => rand(60000, 90000),
                'selling_price' => rand(90000, 130000),
                'current_stock' => $p['stock'],
                'minimum_stock' => 5,
                'unit' => 'pcs',
                'pattern' => $p['name'],
                'is_active' => true,
            ]);
            $product->suppliers()->attach($suppliers->random()->id, ['is_primary' => true]);
        }

        // SARUNG BATIK CAP HALUS
        $category3 = Category::where('slug', 'sarung-batik-cap-halus')->first();
        $products3 = [
            ['name' => 'Daun Akar', 'stock' => 3],
            ['name' => 'Sayapan Kupu', 'stock' => 2],
            ['name' => 'Asmat', 'stock' => 0],
            ['name' => 'Cendrawasih Abu', 'stock' => 0],
            ['name' => 'Kuda Laut', 'stock' => 4],
            ['name' => 'Klaras Coklat', 'stock' => 4],
            ['name' => 'Mega Kuning', 'stock' => 18],
            ['name' => 'Dyaksa', 'stock' => 19],
            ['name' => 'Sepia', 'stock' => 20],
            ['name' => 'Nabastala', 'stock' => 19],
            ['name' => 'Granola', 'stock' => 20],
            ['name' => 'Rempekan', 'stock' => 10],
        ];

        foreach ($products3 as $p) {
            $product = Product::create([
                'category_id' => $category3->id,
                'warehouse_id' => $warehouse->id,
                'name' => $p['name'],
                'description' => 'Sarung batik cap halus motif ' . $p['name'],
                'purchase_price' => rand(70000, 100000),
                'selling_price' => rand(100000, 150000),
                'current_stock' => $p['stock'],
                'minimum_stock' => 5,
                'unit' => 'pcs',
                'pattern' => $p['name'],
                'is_active' => true,
            ]);
            $product->suppliers()->attach($suppliers->random()->id, ['is_primary' => true]);
        }

        // SARUNG WANITA GOYOR CAP
        $category4 = Category::where('slug', 'sarung-wanita-goyor-cap')->first();
        $products4 = [
            ['name' => 'Tahu Coklat', 'stock' => 33],
            ['name' => 'Jasmin Abu', 'stock' => 9],
            ['name' => 'Alwa', 'stock' => 5],
            ['name' => 'Bulu Biru', 'stock' => 33],
            ['name' => 'Kipas Abu', 'stock' => 28],
            ['name' => 'Kenanga Abu', 'stock' => 9],
        ];

        foreach ($products4 as $p) {
            $product = Product::create([
                'category_id' => $category4->id,
                'warehouse_id' => $warehouse->id,
                'name' => $p['name'],
                'description' => 'Sarung wanita goyor cap motif ' . $p['name'],
                'purchase_price' => rand(55000, 85000),
                'selling_price' => rand(85000, 125000),
                'current_stock' => $p['stock'],
                'minimum_stock' => 5,
                'unit' => 'pcs',
                'pattern' => $p['name'],
                'is_active' => true,
            ]);
            $product->suppliers()->attach($suppliers->random()->id, ['is_primary' => true]);
        }
    }
}
