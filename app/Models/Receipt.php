<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_out_id',
        'receipt_number',
        'courier',
        'tracking_number',
        'shipped_date',
        'estimated_delivery',
        'actual_delivery',
        'status',
        'shipping_cost',
        'notes'
    ];

    protected $casts = [
        'shipped_date' => 'date',
        'estimated_delivery' => 'date',
        'actual_delivery' => 'date',
        'shipping_cost' => 'decimal:2',
    ];

    // Relationships
    public function stockOut()
    {
        return $this->belongsTo(StockOut::class);
    }
}
