<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\ActivityLog;
use Illuminate\Http\Request;


class StockInController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');

        $stockIns = StockIn::with(['product', 'supplier', 'warehouse', 'user'])
            ->when($search, function($query) use ($search) {
                $query->search($search);
            })
            ->when($dateFrom, function($query) use ($dateFrom) {
                $query->whereDate('transaction_date', '>=', $dateFrom);
            })
            ->when($dateTo, function($query) use ($dateTo) {
                $query->whereDate('transaction_date', '<=', $dateTo);
            })
            ->latest('transaction_date')
            ->paginate(15);

        $totalQuantity = StockIn::when($dateFrom, function($query) use ($dateFrom) {
                $query->whereDate('transaction_date', '>=', $dateFrom);
            })
            ->when($dateTo, function($query) use ($dateTo) {
                $query->whereDate('transaction_date', '<=', $dateTo);
            })
            ->sum('quantity');

        $totalValue = StockIn::when($dateFrom, function($query) use ($dateFrom) {
                $query->whereDate('transaction_date', '>=', $dateFrom);
            })
            ->when($dateTo, function($query) use ($dateTo) {
                $query->whereDate('transaction_date', '<=', $dateTo);
            })
            ->sum('total_price');

        return view('stock-in.index', compact('stockIns', 'search', 'dateFrom', 'dateTo', 'totalQuantity', 'totalValue'));
    }

    public function create()
    {
        $products = Product::active()->with('category')->get();
        $suppliers = Supplier::active()->get();
        $warehouses = Warehouse::active()->get();

        return view('stock-in.create', compact('products', 'suppliers', 'warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
            'reference_number' => 'nullable|string|max:100',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];

        $stockIn = StockIn::create($validated);

        ActivityLog::log('create', $stockIn, "Created stock in: {$stockIn->transaction_code}");

        return redirect()->route('stock-in.index')
            ->with('success', 'Stock in recorded successfully. Transaction Code: ' . $stockIn->transaction_code);
    }

    public function show(StockIn $stockIn)
    {
        $stockIn->load(['product.category', 'supplier', 'warehouse', 'user']);

        return view('stock-in.show', compact('stockIn'));
    }

    public function edit(StockIn $stockIn)
    {
        $products = Product::active()->with('category')->get();
        $suppliers = Supplier::active()->get();
        $warehouses = Warehouse::active()->get();

        return view('stock-in.edit', compact('stockIn', 'products', 'suppliers', 'warehouses'));
    }

    public function update(Request $request, StockIn $stockIn)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|integer|min:1',
            'unit_price' => 'required|numeric|min:0',
            'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
            'reference_number' => 'nullable|string|max:100',
        ]);

        // Adjust product stock
        $product = Product::find($stockIn->product_id);
        $product->decrement('current_stock', $stockIn->quantity);

        $newProduct = Product::find($validated['product_id']);
        $newProduct->increment('current_stock', $validated['quantity']);

        $validated['total_price'] = $validated['quantity'] * $validated['unit_price'];
        $stockIn->update($validated);

        ActivityLog::log('update', $stockIn, "Updated stock in: {$stockIn->transaction_code}");

        return redirect()->route('stock-in.index')
            ->with('success', 'Stock in updated successfully.');
    }

    public function destroy(StockIn $stockIn)
    {
        // Reverse stock
        $product = $stockIn->product;
        $product->decrement('current_stock', $stockIn->quantity);

        $code = $stockIn->transaction_code;
        $stockIn->delete();

        ActivityLog::log('delete', $stockIn, "Deleted stock in: {$code}");

        return redirect()->route('stock-in.index')
            ->with('success', 'Stock in deleted successfully.');
    }
}
