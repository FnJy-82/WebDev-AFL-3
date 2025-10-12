<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
   protected $fillable = [
        'name', 'logo', 'description', 'vision', 
        'mission_1', 'mission_2', 'mission_3', 'mission_4',
        'address', 'city'
    ];

    public function getLogoUrlAttribute()
    {
        $githubRawUrl = 'https://raw.githubusercontent.com/HDSH-Dharma/allstock-warehouse/main/public/images/warehouse/';
        return $githubRawUrl . $this->logo;
    }

    public function getMissionsAttribute()
    {
        return array_filter([$this->mission_1, $this->mission_2, $this->mission_3, $this->mission_4]);
    }

    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->city;
    }
}
