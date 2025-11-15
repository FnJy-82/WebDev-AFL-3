<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\StockAlert;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalProducts = Product::count();
        $lowStockProducts = Product::lowStock()->count();
        $totalCategories = Category::count();
        $totalSuppliers = Supplier::count();

        // Today's transactions
        $todayStockIn = StockIn::whereDate('transaction_date', today())->sum('quantity');
        $todayStockOut = StockOut::whereDate('transaction_date', today())->sum('quantity');

        // This month's value
        $monthStockInValue = StockIn::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('total_price');
        $monthStockOutValue = StockOut::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->sum('total_price');

        // Active alerts
        $activeAlerts = StockAlert::active()
            ->with(['product', 'warehouse'])
            ->latest()
            ->take(5)
            ->get();

        // Recent stock movements (last 10)
        $recentStockIns = StockIn::with(['product', 'supplier'])
            ->latest()
            ->take(5)
            ->get();

        $recentStockOuts = StockOut::with(['product'])
            ->latest()
            ->take(5)
            ->get();

        // Top selling products this month
        $topProducts = StockOut::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->with('product')
            ->get();

        // Low stock products
        $lowStockItems = Product::lowStock()
            ->with('category')
            ->orderBy('current_stock')
            ->take(10)
            ->get();

        // Chart data - Last 7 days stock in/out
        $last7Days = collect(range(6, 0))->map(function($daysAgo) {
            $date = now()->subDays($daysAgo);
            return [
                'date' => $date->format('M d'),
                'stock_in' => StockIn::whereDate('transaction_date', $date)->sum('quantity'),
                'stock_out' => StockOut::whereDate('transaction_date', $date)->sum('quantity'),
            ];
        });

        return view('dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'totalCategories',
            'totalSuppliers',
            'todayStockIn',
            'todayStockOut',
            'monthStockInValue',
            'monthStockOutValue',
            'activeAlerts',
            'recentStockIns',
            'recentStockOuts',
            'topProducts',
            'lowStockItems',
            'last7Days'
        ));
    }
}
