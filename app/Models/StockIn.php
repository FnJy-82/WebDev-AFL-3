<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_in';

    protected $fillable = [
        'transaction_code',
        'product_id',
        'supplier_id',
        'warehouse_id',
        'user_id',
        'quantity',
        'unit_price',
        'total_price',
        'transaction_date',
        'notes',
        'reference_number'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'transaction_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($stockIn) {
            if (empty($stockIn->transaction_code)) {
                $stockIn->transaction_code = static::generateTransactionCode();
            }
            $stockIn->total_price = $stockIn->quantity * $stockIn->unit_price;
        });

        static::created(function ($stockIn) {
            // Update product stock
            $product = $stockIn->product;
            $oldStock = $product->current_stock;
            $product->increment('current_stock', $stockIn->quantity);

            // Create stock movement log
            StockMovement::create([
                'product_id' => $stockIn->product_id,
                'warehouse_id' => $stockIn->warehouse_id,
                'user_id' => $stockIn->user_id,
                'type' => 'in',
                'quantity' => $stockIn->quantity,
                'stock_before' => $oldStock,
                'stock_after' => $oldStock + $stockIn->quantity,
                'reference_type' => 'StockIn',
                'reference_id' => $stockIn->id,
                'notes' => 'Stock in from supplier',
                'movement_date' => now(),
            ]);
        });
    }

    public static function generateTransactionCode()
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', now())->count() + 1;
        return 'IN-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('transaction_code', 'like', "%{$search}%")
            ->orWhereHas('product', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
    }
}
