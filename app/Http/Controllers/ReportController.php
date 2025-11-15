<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\DailyReport;
use App\Models\MonthlyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockReportExport;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function daily(Request $request)
    {
        $date = $request->get('date', today()->format('Y-m-d'));

        $stockIns = StockIn::with(['product', 'supplier'])
            ->whereDate('transaction_date', $date)
            ->get();

        $stockOuts = StockOut::with(['product'])
            ->whereDate('transaction_date', $date)
            ->get();

        $totalStockIn = $stockIns->sum('quantity');
        $totalStockOut = $stockOuts->sum('quantity');
        $totalValueIn = $stockIns->sum('total_price');
        $totalValueOut = $stockOuts->sum('total_price');

        return view('reports.daily', compact(
            'date',
            'stockIns',
            'stockOuts',
            'totalStockIn',
            'totalStockOut',
            'totalValueIn',
            'totalValueOut'
        ));
    }

    public function monthly(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $stockIns = StockIn::whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->get();

        $stockOuts = StockOut::whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->get();

        $totalStockIn = $stockIns->sum('quantity');
        $totalStockOut = $stockOuts->sum('quantity');
        $totalValueIn = $stockIns->sum('total_price');
        $totalValueOut = $stockOuts->sum('total_price');
        $totalRevenue = $totalValueOut - $totalValueIn;

        // Category breakdown
        $categoryBreakdown = StockOut::whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->join('products', 'stock_out.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(stock_out.quantity) as total'))
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // Top products
        $topProducts = StockOut::whereMonth('transaction_date', $month)
            ->whereYear('transaction_date', $year)
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->with('product')
            ->get();

        return view('reports.monthly', compact(
            'month',
            'year',
            'totalStockIn',
            'totalStockOut',
            'totalValueIn',
            'totalValueOut',
            'totalRevenue',
            'categoryBreakdown',
            'topProducts'
        ));
    }

    public function export(Request $request)
    {
        $type = $request->get('type', 'daily');
        $date = $request->get('date', today()->format('Y-m-d'));

        return Excel::download(new StockReportExport($type, $date), "stock_report_{$type}_{$date}.xlsx");
    }
}
