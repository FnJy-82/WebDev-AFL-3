<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\Product;
use App\Models\Warehouse;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class StockOutController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $stockOuts = StockOut::with(['product', 'warehouse', 'user', 'receipt'])
            ->when($search, function($query) use ($search) {
                $query->search($search);
            })
            ->when($status, function($query) use ($status) {
                $query->where('status', $status);
            })
            ->when($dateFrom, function($query) use ($dateFrom) {
                $query->whereDate('transaction_date', '>=', $dateFrom);
            })
            ->when($dateTo, function($query) use ($dateTo) {
                $query->whereDate('transaction_date', '<=', $dateTo);
            })
            ->latest('transaction_date')
            ->paginate(15);

        $totalQuantity = StockOut::when($dateFrom, function($query) use ($dateFrom) {
                $query->whereDate('transaction_date', '>=', $dateFrom);
            })
            ->when($dateTo, function($query) use ($dateTo) {
                $query->whereDate('transaction_date', '<=', $dateTo);
            })
            ->sum('quantity');

        $totalValue = StockOut::when($dateFrom, function($query) use ($dateFrom) {
                $query->whereDate('transaction_date', '>=', $dateFrom);
            })
            ->when($dateTo, function($query) use ($dateTo) {
                $query->whereDate('transaction_date', '<=', $dateTo);
            })
            ->sum('total_price');

        return view('stock-out.index', compact('stockOuts', 'search', 'status', 'dateFrom', 'dateTo', 'totalQuantity', 'totalValue'));
    }

    public function create()
    {
        $products = Product::active()
            ->where('current_stock', '>', 0)
            ->with('category')
            ->get();
        $warehouses = Warehouse::active()->get();

        return view('stock-out.create', compact('products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string',
            'status' => 'required|in:pending,shipped,delivered',
            'notes' => 'nullable|string',
        ]);

        // Check stock availability
        $product = Product::find($validated['product_id']);
        if ($product->current_stock < $validated['quantity']) {
            return back()->withErrors(['quantity' => 'Insufficient stock. Available: ' . $product->current_stock])
                ->withInput();
        }

        $validated['user_id'] = auth()->id();
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

        $stockOut = StockOut::create($validated);

        ActivityLog::log('create', $stockOut, "Created stock out: {$stockOut->transaction_code}");

        return redirect()->route('stock-out.index')
            ->with('success', 'Stock out recorded successfully. Transaction Code: ' . $stockOut->transaction_code);
    }

    public function show(StockOut $stockOut)
    {
        $stockOut->load(['product.category', 'warehouse', 'user', 'receipt']);

        return view('stock-out.show', compact('stockOut'));
    }

    public function edit(StockOut $stockOut)
    {
        $products = Product::active()->with('category')->get();
        $warehouses = Warehouse::active()->get();

        return view('stock-out.edit', compact('stockOut', 'products', 'warehouses'));
    }

    public function update(Request $request, StockOut $stockOut)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'shipping_address' => 'required|string',
            'status' => 'required|in:pending,shipped,delivered',
            'notes' => 'nullable|string',
        ]);

        $stockOut->update($validated);

        ActivityLog::log('update', $stockOut, "Updated stock out: {$stockOut->transaction_code}");

        return redirect()->route('stock-out.index')
            ->with('success', 'Stock out updated successfully.');
    }

    public function destroy(StockOut $stockOut)
    {
        // Reverse stock
        $product = $stockOut->product;
        $product->increment('current_stock', $stockOut->quantity);

        $code = $stockOut->transaction_code;
        $stockOut->delete();

        ActivityLog::log('delete', $stockOut, "Deleted stock out: {$code}");

        return redirect()->route('stock-out.index')
            ->with('success', 'Stock out deleted successfully.');
    }
}
