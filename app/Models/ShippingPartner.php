<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingPartner extends Model
{
    protected $fillable = ['name', 'logo', 'service_type', 'delivery_coverage'];

    public function getLogoUrlAttribute()
    {
        $imagepath = 'images/shipping/';
        return $imagepath . $this->logo;
    }

    public function getCoverageListAttribute()
    {
        return explode(',', $this->delivery_coverage);
    }
}
