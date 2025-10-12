<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'shopee_link'];

    public function getDisplayNameAttribute()
    {
        return ucwords($this->name);
    }
}
