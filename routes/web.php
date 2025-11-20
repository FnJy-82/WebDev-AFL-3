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
use App\Models\Warehouse;
use App\Models\Supplier;
use App\Models\ShippingPartner;

/*
|--------------------------------------------------------------------------
| Public (Guest) Routes
|--------------------------------------------------------------------------
|
| These routes are accessible to everyone, even if they are not logged in.
|
*/

// The main homepage

Route::get('/', function () {
    // Fetch the first warehouse from your database
    $warehouse = Warehouse::firstOrFail();

    // Fetch some suppliers to show on the homepage (e.g., the first 6)
    $suppliers = Supplier::take(6)->get();


    $shippingPartners = ShippingPartner::all();

    // Pass all three variables to the 'home' view
    return view('home', [
        'warehouse' => $warehouse,
        'suppliers' => $suppliers,
        'shippingPartners' => $shippingPartners
    ]);
})->name('home');

// The public warehouse info page
Route::get('/warehouse', [WarehouseController::class, 'index'])->name('warehouse');


/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
|
| All routes in this group require the user to be logged in.
| The 'verified' middleware means they must also have verified their email.
|
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Suppliers
    // OLD: Route::get('/suppliers', [SupplierController::class, 'index'])->name('suppliers');
    // NEW: Use Route::resource to match the other models and create 'suppliers.index'
    Route::resource('suppliers', SupplierController::class);

    // Products
    Route::resource('products', ProductController::class);

    // Stock In
    Route::resource('stock-in', StockInController::class);

    // Stock Out
    Route::resource('stock-out', StockOutController::class);

    // Receipts
    Route::resource('receipts', ReceiptController::class);

    // Reports
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/daily', [ReportController::class, 'daily'])->name('daily');
        Route::get('/monthly', [ReportController::class, 'monthly'])->name('monthly');
        Route::get('/export', [ReportController::class, 'export'])->name('export');
    });

    // API endpoints for AJAX
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


/*
|--------------------------------------------------------------------------
| Auth Routes (Login, Register, etc.)
|--------------------------------------------------------------------------
|
| This file is included from Breeze and handles login, registration, etc.
|
*/
require __DIR__.'/auth.php';
