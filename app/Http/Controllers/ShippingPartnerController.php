<?php

namespace App\Http\Controllers;

use App\Models\ShippingPartner;

class ShippingPartnerController
{
    public function shippingPartners()
    {
        $shippingPartners = ShippingPartner::all();
        return view('shipping-partners', compact('shippingPartners'));
    }
}
