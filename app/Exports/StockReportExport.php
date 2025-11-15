<?php

namespace App\Exports;

use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Collection;

class StockReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $type;
    protected $date;

    public function __construct($type = 'daily', $date = null)
    {
        $this->type = $type;
        $this->date = $date ?? today()->format('Y-m-d');
    }

    public function collection()
    {
        if ($this->type === 'stock') {
            return Product::with(['category', 'warehouse'])->get();
        }

        if ($this->type === 'stock-in') {
            return StockIn::with(['product', 'supplier', 'warehouse'])
                ->whereDate('transaction_date', $this->date)
                ->get();
        }

        if ($this->type === 'stock-out') {
            return StockOut::with(['product', 'warehouse'])
                ->whereDate('transaction_date', $this->date)
                ->get();
        }

        // Default: combined daily report
        $stockIns = StockIn::with(['product', 'supplier'])
            ->whereDate('transaction_date', $this->date)
            ->get();

        $stockOuts = StockOut::with(['product'])
            ->whereDate('transaction_date', $this->date)
            ->get();

        return collect([
            ['type' => 'summary', 'data' => [
                'Total Stock In' => $stockIns->sum('quantity'),
                'Total Stock Out' => $stockOuts->sum('quantity'),
                'Total Value In' => $stockIns->sum('total_price'),
                'Total Value Out' => $stockOuts->sum('total_price'),
            ]],
            ['type' => 'stock_in', 'data' => $stockIns],
            ['type' => 'stock_out', 'data' => $stockOuts],
        ]);
    }

    public function headings(): array
    {
        if ($this->type === 'stock') {
            return [
                'SKU',
                'Product Name',
                'Category',
                'Warehouse',
                'Current Stock',
                'Minimum Stock',
                'Status',
                'Purchase Price',
                'Selling Price',
                'Color',
                'Pattern',
            ];
        }

        if ($this->type === 'stock-in') {
            return [
                'Transaction Code',
                'Date',
                'Product',
                'Supplier',
                'Quantity',
                'Unit Price',
                'Total Price',
                'Reference',
            ];
        }

        if ($this->type === 'stock-out') {
            return [
                'Transaction Code',
                'Date',
                'Product',
                'Customer',
                'Quantity',
                'Unit Price',
                'Total Price',
                'Status',
            ];
        }

        return ['Report Type', 'Details'];
    }

    public function map($row): array
    {
        if ($this->type === 'stock' && $row instanceof Product) {
            return [
                $row->sku,
                $row->name,
                $row->category->name,
                $row->warehouse->name,
                $row->current_stock,
                $row->minimum_stock,
                $row->stock_status,
                $row->purchase_price,
                $row->selling_price,
                $row->color,
                $row->pattern,
            ];
        }

        if ($this->type === 'stock-in' && $row instanceof StockIn) {
            return [
                $row->transaction_code,
                $row->transaction_date->format('d/m/Y'),
                $row->product->name,
                $row->supplier->name,
                $row->quantity,
                $row->unit_price,
                $row->total_price,
                $row->reference_number,
            ];
        }

        if ($this->type === 'stock-out' && $row instanceof StockOut) {
            return [
                $row->transaction_code,
                $row->transaction_date->format('d/m/Y'),
                $row->product->name,
                $row->customer_name,
                $row->quantity,
                $row->unit_price,
                $row->total_price,
                $row->status,
            ];
        }

        return [$row['type'], json_encode($row['data'])];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ],
            ],
        ];
    }
}
