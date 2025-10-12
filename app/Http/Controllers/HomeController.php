<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\ShippingPartner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $warehouse = Warehouse::first();
        $suppliers = Supplier::all();
        $shippingPartners = ShippingPartner::all();

        return view('home', compact('warehouse', 'suppliers', 'shippingPartners'));
    }

    public function suppliers()
    {
        $suppliers = Supplier::all();
        return view('suppliers', compact('suppliers'));
    }

    public function warehouse()
    {
        $warehouse = Warehouse::first();
        return view('warehouse', compact('warehouse'));
    }

    public function shippingPartners()
    {
        $shippingPartners = ShippingPartner::all();
        return view('shipping-partners', compact('shippingPartners'));
    }
}