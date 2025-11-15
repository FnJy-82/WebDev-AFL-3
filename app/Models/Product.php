<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'warehouse_id',
        'sku',
        'name',
        'slug',
        'description',
        'image',
        'purchase_price',
        'selling_price',
        'current_stock',
        'minimum_stock',
        'unit',
        'color',
        'size',
        'pattern',
        'is_active'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'current_stock' => 'integer',
        'minimum_stock' => 'integer',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->sku)) {
                $product->sku = static::generateSKU();
            }
        });

        // Check for low stock alerts after update
        static::updated(function ($product) {
            if ($product->current_stock <= $product->minimum_stock) {
                StockAlert::firstOrCreate([
                    'product_id' => $product->id,
                    'warehouse_id' => $product->warehouse_id,
                    'status' => 'active',
                ], [
                    'alert_type' => $product->current_stock == 0 ? 'out_of_stock' : 'low_stock',
                    'current_stock' => $product->current_stock,
                    'threshold' => $product->minimum_stock,
                ]);
            }
        });
    }

    // Generate unique SKU
    public static function generateSKU()
    {
        do {
            $sku = 'BTK-' . strtoupper(Str::random(8));
        } while (static::where('sku', $sku)->exists());

        return $sku;
    }

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier')
            ->withPivot('supply_price', 'lead_time_days', 'is_primary')
            ->withTimestamps();
    }

    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }

    public function stockOuts()
    {
        return $this->hasMany(StockOut::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class);
    }

    public function stockAlerts()
    {
        return $this->hasMany(StockAlert::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeLowStock($query)
    {
        return $query->whereColumn('current_stock', '<=', 'minimum_stock');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('pattern', 'like', "%{$search}%");
        });
    }

    // Accessors
    public function getIsLowStockAttribute()
    {
        return $this->current_stock <= $this->minimum_stock;
    }

    public function getStockStatusAttribute()
    {
        if ($this->current_stock == 0) return 'out_of_stock';
        if ($this->current_stock <= $this->minimum_stock) return 'low_stock';
        return 'in_stock';
    }
}
