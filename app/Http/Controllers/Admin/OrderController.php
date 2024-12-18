<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\OrderStatusUpdated; // Import your notification class
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Display all orders
    public function index()
{
    // Fetch all orders, sorting by the newest customer's creation date first
    $orders = Order::join('users', 'orders.user_id', '=', 'users.id')
                   ->orderBy('users.created_at', 'desc') // Sort by customer creation date
                   ->select('orders.*') // Select all order fields
                   ->get();

    return view('admin.orders.index', compact('orders')); // Pass sorted orders to the view
}

    // Show form to edit an order
    public function edit($id)
    {
        $order = Order::findOrFail($id); // Find order by ID
        return view('admin.orders.edit', compact('order')); // Pass order to the edit view
    }

    // Update order status
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'shipping_status' => 'required|string',
        ]);

        // Find the order by ID
        $order = Order::findOrFail($id);
        $order->shipping_status = $request->shipping_status; // Update shipping status
        $order->save(); // Save changes

        // Notify the user of the status change
        $user = User::find($order->user_id); // Assuming each order has a user_id field
        $user->notify(new OrderStatusUpdated($order)); // Pass the entire order object

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated and user notified successfully!');
    }

    // Generate sales report for completed orders
    public function report()
    {
        $completedOrders = Order::all(); // Removes the payment_status condition
        return view('admin.orders.report', compact('completedOrders'));
    }
    
}
