<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingPartner extends Model
{
    protected $fillable = ['name', 'logo', 'service_type', 'delivery_coverage'];

    public function getLogoUrlAttribute()
    {
        $githubRawUrl = 'https://raw.githubusercontent.com/HDSH-Dharma/allstock-warehouse/main/public/images/shipping/';
        return $githubRawUrl . $this->logo;
    }

    public function getCoverageListAttribute()
    {
        return explode(',', $this->delivery_coverage);
    }
}
