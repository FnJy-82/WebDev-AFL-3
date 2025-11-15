<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;

class WarehouseController extends Controller
{
    public function warehouse()
    {
        $warehouse = Warehouse::first();
        return view('warehouse', compact('warehouse'));
    }
}
