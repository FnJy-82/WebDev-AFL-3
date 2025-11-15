<?php

namespace Database\Seeders;

use App\Models\StockIn;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class StockInSeeder extends Seeder
{
    public function run(): void
    {
        $warehouse = Warehouse::first();
        $products = Product::all();
        $supplier = Supplier::first();
        $user = \App\Models\User::first();

        // Simulate stock in on 2025-10-20 based on real data
        foreach ($products as $product) {
            if ($product->current_stock > 0) {
                StockIn::create([
                    'product_id' => $product->id,
                    'supplier_id' => $supplier->id,
                    'warehouse_id' => $warehouse->id,
                    'user_id' => $user->id,
                    'quantity' => $product->current_stock,
                    'unit_price' => $product->purchase_price,
                    'total_price' => $product->current_stock * $product->purchase_price,
                    'transaction_date' => '2025-10-20',
                    'notes' => 'Initial stock from supplier',
                    'reference_number' => 'PO-20251020-' . str_pad($product->id, 3, '0', STR_PAD_LEFT),
                ]);
            }
        }
    }
}
