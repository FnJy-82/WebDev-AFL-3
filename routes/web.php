<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/warehouse', [WarehouseController::class, 'index'])->name('warehouse');

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Categories - Route Model Binding
    Route::resource('categories', CategoryController::class);

    // Suppliers - Route Model Binding
    Route::resource('suppliers', SupplierController::class);

    // Products - Route Model Binding (with image CRUD)
    Route::resource('products', ProductController::class);

    // Stock In - Route Model Binding
    Route::resource('stock-in', StockInController::class);

    // Stock Out - Route Model Binding
    Route::resource('stock-out', StockOutController::class);

    // Receipts - Route Model Binding
    Route::resource('receipts', ReceiptController::class);

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/daily', [ReportController::class, 'daily'])->name('daily');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
        Route::get('/export', [ReportController::class, 'export'])->name('export');
    });

    // Additional API endpoints for AJAX
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/products/{product}', function(\App\Models\Product $product) {
            return response()->json($product->load('category', 'warehouse'));
        })->name('products.show');

        Route::get('/stock-check/{product}', function(\App\Models\Product $product) {
            return response()->json([
                'current_stock' => $product->current_stock,
                'minimum_stock' => $product->minimum_stock,
                'is_low_stock' => $product->is_low_stock,
                'status' => $product->stock_status,
            ]);
        })->name('stock.check');
    });
});

require __DIR__.'/auth.php';
