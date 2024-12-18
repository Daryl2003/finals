<?php

// App/Http/Controllers/MyOrdersController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class MyOrdersController extends Controller
{
    
    public function index()
    {
        // Get the authenticated user's orders, sorted by newest first
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
    
        // Add a user-specific order number in reverse order (newest at the top)
        $totalOrders = $orders->count();
        foreach ($orders as $key => $order) {
            // Calculate the user-specific Order ID (starting from 1 for the first order they made)
            // Since we're ordering by newest first, reverse the order ID calculation
            $order->user_order_id = $totalOrders - $key;
        }
    
        return view('myorders.index', compact('orders'));
    }
    

}
