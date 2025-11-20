<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'shopee_link',
        'contact_person',
        'phone',
        'email',
        'address',
        'city',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($supplier) {
            if (empty($supplier->slug)) {
                $supplier->slug = Str::slug($supplier->name);
            }
        });
    }

    // Relationships
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_supplier')
            ->withPivot('supply_price', 'lead_time_days', 'is_primary')
            ->withTimestamps();
    }

    public function stockIns()
    {
        return $this->hasMany(StockIn::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
