<?php

namespace App\Http\Controllers;

use App\Models\Receipt;
use App\Models\StockOut;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ReceiptController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $status = $request->get('status');

        $receipts = Receipt::with(['stockOut.product', 'stockOut.warehouse'])
            ->when($search, function($query) use ($search) {
                $query->where('receipt_number', 'like', "%{$search}%")
                    ->orWhere('tracking_number', 'like', "%{$search}%")
                    ->orWhere('courier', 'like', "%{$search}%");
            })
            ->when($status, function($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15);

        return view('receipts.index', compact('receipts', 'search', 'status'));
    }

    public function create()
    {
        $stockOuts = StockOut::whereDoesntHave('receipt')
            ->with('product')
            ->latest()
            ->get();

        return view('receipts.create', compact('stockOuts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stock_out_id' => 'required|exists:stock_out,id|unique:receipts,stock_out_id',
            'receipt_number' => 'required|string|unique:receipts,receipt_number',
            'courier' => 'required|string|max:100',
            'tracking_number' => 'nullable|string|max:100',
            'shipped_date' => 'nullable|date',
            'estimated_delivery' => 'nullable|date',
            'shipping_cost' => 'required|numeric|min:0',
            'status' => 'required|in:pending,in_transit,delivered',
            'notes' => 'nullable|string',
        ]);

        $receipt = Receipt::create($validated);

        // Update stock out status
        $receipt->stockOut->update(['status' => 'shipped']);

        ActivityLog::log('create', $receipt, "Created receipt: {$receipt->receipt_number}");

        return redirect()->route('receipts.index')
            ->with('success', 'Receipt created successfully.');
    }

    public function show(Receipt $receipt)
    {
        $receipt->load(['stockOut.product', 'stockOut.warehouse', 'stockOut.user']);

        return view('receipts.show', compact('receipt'));
    }

    public function edit(Receipt $receipt)
    {
        return view('receipts.edit', compact('receipt'));
    }

    public function update(Request $request, Receipt $receipt)
    {
        $validated = $request->validate([
            'courier' => 'required|string|max:100',
            'tracking_number' => 'nullable|string|max:100',
            'shipped_date' => 'nullable|date',
            'estimated_delivery' => 'nullable|date',
            'actual_delivery' => 'nullable|date',
            'shipping_cost' => 'required|numeric|min:0',
            'status' => 'required|in:pending,in_transit,delivered',
            'notes' => 'nullable|string',
        ]);

        $receipt->update($validated);

        // Update stock out status if delivered
        if ($validated['status'] == 'delivered') {
            $receipt->stockOut->update(['status' => 'delivered']);
        }

        ActivityLog::log('update', $receipt, "Updated receipt: {$receipt->receipt_number}");

        return redirect()->route('receipts.index')
            ->with('success', 'Receipt updated successfully.');
    }

    public function destroy(Receipt $receipt)
    {
        $number = $receipt->receipt_number;
        $receipt->delete();

        ActivityLog::log('delete', $receipt, "Deleted receipt: {$number}");

        return redirect()->route('receipts.index')
            ->with('success', 'Receipt deleted successfully.');
    }
}
