<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $table = 'stock_out';

    protected $fillable = [
        'transaction_code',
        'product_id',
        'warehouse_id',
        'user_id',
        'quantity',
        'unit_price',
        'total_price',
        'transaction_date',
        'customer_name',
        'customer_phone',
        'shipping_address',
        'status',
        'notes'
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

        static::creating(function ($stockOut) {
            if (empty($stockOut->transaction_code)) {
                $stockOut->transaction_code = static::generateTransactionCode();
            }
            $stockOut->total_price = $stockOut->quantity * $stockOut->unit_price;
        });

        static::created(function ($stockOut) {
            // Update product stock
            $product = $stockOut->product;
            $oldStock = $product->current_stock;
            $product->decrement('current_stock', $stockOut->quantity);

            // Create stock movement log
            StockMovement::create([
                'product_id' => $stockOut->product_id,
                'warehouse_id' => $stockOut->warehouse_id,
                'user_id' => $stockOut->user_id,
                'type' => 'out',
                'quantity' => $stockOut->quantity,
                'stock_before' => $oldStock,
                'stock_after' => $oldStock - $stockOut->quantity,
                'reference_type' => 'StockOut',
                'reference_id' => $stockOut->id,
                'notes' => 'Stock out to customer',
                'movement_date' => now(),
            ]);
        });
    }

    public static function generateTransactionCode()
    {
        $date = now()->format('Ymd');
        $count = static::whereDate('created_at', now())->count() + 1;
        return 'OUT-' . $date . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }

    // Relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function receipt()
    {
        return $this->hasOne(Receipt::class);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('transaction_code', 'like', "%{$search}%")
            ->orWhere('customer_name', 'like', "%{$search}%");
    }
}
