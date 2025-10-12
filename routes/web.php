<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/suppliers', [HomeController::class, 'suppliers'])->name('suppliers');

Route::get('/warehouse', [HomeController::class, 'warehouse'])->name('warehouse');

Route::get('/shipping-partners', [HomeController::class, 'shippingPartners'])->name('shipping-partners');