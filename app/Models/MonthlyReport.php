<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'month',
        'warehouse_id',
        'total_stock_in',
        'total_stock_out',
        'total_value_in',
        'total_value_out',
        'total_revenue',
        'total_transactions',
        'category_breakdown',
        'supplier_breakdown',
        'best_selling_products',
        'summary'
    ];

    protected $casts = [
        'year' => 'integer',
        'month' => 'integer',
        'total_stock_in' => 'integer',
        'total_stock_out' => 'integer',
        'total_value_in' => 'decimal:2',
        'total_value_out' => 'decimal:2',
        'total_revenue' => 'decimal:2',
        'total_transactions' => 'integer',
        'category_breakdown' => 'array',
        'supplier_breakdown' => 'array',
        'best_selling_products' => 'array',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
