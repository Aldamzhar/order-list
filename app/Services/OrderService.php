<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderService
{
    public function getAllOrders(Request $request)
    {
        return Order::with('user')->get();
    }
}
