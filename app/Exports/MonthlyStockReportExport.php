<?php

namespace App\Exports;

use App\Models\StockIn;
use App\Models\StockOut;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MonthlyStockReportExport implements WithMultipleSheets
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function sheets(): array
    {
        return [
            new MonthlyStockInSheet($this->month, $this->year),
            new MonthlyStockOutSheet($this->month, $this->year),
            new MonthlySummarySheet($this->month, $this->year),
        ];
    }
}

class MonthlyStockInSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return StockIn::with(['product', 'supplier'])
            ->whereMonth('transaction_date', $this->month)
            ->whereYear('transaction_date', $this->year)
            ->get()
            ->map(function ($item) {
                return [
                    'transaction_code' => $item->transaction_code,
                    'date' => $item->transaction_date->format('d/m/Y'),
                    'product' => $item->product->name,
                    'supplier' => $item->supplier->name,
                    'quantity' => $item->quantity,
                    'total_price' => $item->total_price,
                ];
            });
    }

    public function headings(): array
    {
        return ['Code', 'Date', 'Product', 'Supplier', 'Quantity', 'Total Price'];
    }

    public function title(): string
    {
        return 'Stock In';
    }
}

class MonthlyStockOutSheet implements FromCollection, WithHeadings, WithTitle
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return StockOut::with(['product'])
            ->whereMonth('transaction_date', $this->month)
            ->whereYear('transaction_date', $this->year)
            ->get()
            ->map(function ($item) {
                return [
                    'transaction_code' => $item->transaction_code,
                    'date' => $item->transaction_date->format('d/m/Y'),
                    'product' => $item->product->name,
                    'customer' => $item->customer_name,
                    'quantity' => $item->quantity,
                    'total_price' => $item->total_price,
                ];
            });
    }

    public function headings(): array
    {
        return ['Code', 'Date', 'Product', 'Customer', 'Quantity', 'Total Price'];
    }

    public function title(): string
    {
        return 'Stock Out';
    }
}

class MonthlySummarySheet implements FromCollection, WithHeadings, WithTitle
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        $stockIns = StockIn::whereMonth('transaction_date', $this->month)
            ->whereYear('transaction_date', $this->year);

        $stockOuts = StockOut::whereMonth('transaction_date', $this->month)
            ->whereYear('transaction_date', $this->year);

        return collect([
            ['Metric', 'Value'],
            ['Total Stock In Qty', $stockIns->sum('quantity')],
            ['Total Stock Out Qty', $stockOuts->sum('quantity')],
            ['Total Stock In Value', $stockIns->sum('total_price')],
            ['Total Stock Out Value', $stockOuts->sum('total_price')],
            ['Total Transactions', $stockIns->count() + $stockOuts->count()],
        ]);
    }

    public function headings(): array
    {
        return [];
    }

    public function title(): string
    {
        return 'Summary';
    }
}
