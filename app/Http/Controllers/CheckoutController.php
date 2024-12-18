<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CheckoutController extends Controller
{
    // Show the checkout page
    public function show()
    {
        $cart = Session::get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        return view('checkout.index', compact('cart'));
    }

    // Handle the checkout process
    public function process(Request $request)
    {
        // Assuming the cart data is in the session
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Your cart is empty.');
        }

        // Calculate the total amount from the cart
        $totalAmount = 0;
        foreach ($cart as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }

        // Prepare the product details for the order
        $productDetails = [];
        foreach ($cart as $id => $item) {
            $productDetails[] = [
                'product_id' => $id,
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        }

        // Create the order in the database
        try {
            \DB::beginTransaction();

            // Create the order record
            $order = Order::create([
                'user_id' => auth()->id(),  // Ensure the user is authenticated
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'shipping_address' => $request->address,
                'customer_name' => $request->name,
                'customer_email' => $request->email,
                'payment_status' => 'pending',  // Default to 'pending' initially
                'shipping_status' => 'pending',  // Default to 'pending' initially
                'product_details' => json_encode($productDetails),  // Store product details as JSON
            ]);

            \DB::commit();

            // Optionally, clear the cart if the order is successful
            session()->forget('cart');

            return redirect()->route('order.success', $order->id)->with('success', 'Your order has been placed successfully!');
        } catch (\Exception $e) {
            // If anything goes wrong, rollback the transaction
            \DB::rollback();

            // Log the error
            \Log::error('Order processing failed: ' . $e->getMessage());

            return redirect()->route('cart.view')->with('error', 'An error occurred while processing your order.');
        }
    }

    // PayPal Checkout
    // PayPal Checkout
// PayPal Checkout
public function paypalCheckout()
{
    $paypal = new PayPalClient;
    $paypal->setApiCredentials(config('paypal'));
    $paypal->setAccessToken($paypal->getAccessToken());

    // Calculate the total order amount from the cart
    $cart = Session::get('cart', []);
    $totalAmount = 0;

    foreach ($cart as $id => $item) {
        $product = Product::find($id);
        if ($product) {
            if ($product->discount) {
                $discountedPrice = $product->price - ($product->price * ($product->discount / 100));
                $totalAmount += $discountedPrice * $item['quantity'];
            } else {
                $totalAmount += $product->price * $item['quantity'];
            }
        }
    }

    // Create PayPal order
    try {
        $order = $paypal->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($totalAmount, 2, '.', ''),
                    ]
                ]
            ],
            "application_context" => [
                "return_url" => route('checkout.paypal.success'),  // URL after successful payment
                "cancel_url" => route('checkout.paypal.cancel'),  // URL if payment is canceled
            ]
        ]);

        // Log the order response for debugging
        \Log::info('PayPal Order Response: ', $order);

        if (isset($order['id']) && $order['status'] === 'CREATED') {
            // Find the "approve" link
            $approveLink = null;
            foreach ($order['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    $approveLink = $link['href'];
                    break;
                }
            }

            // If the approve link is found, redirect to it
            if ($approveLink) {
                return redirect()->away($approveLink);
            }
        }

        return redirect()->route('checkout')->with('error', 'Something went wrong while creating the PayPal order.');
    } catch (\Exception $e) {
        // Log the exception
        \Log::error('Error creating PayPal order: ' . $e->getMessage());
        return redirect()->route('checkout')->with('error', 'An error occurred during the PayPal checkout process.');
    }
}


    // PayPal Success Handling
    // PayPal Success Handling
    public function paypalSuccess(Request $request)
{
    $paypal = new PayPalClient;
    $paypal->setApiCredentials(config('paypal'));
    $paypal->setAccessToken($paypal->getAccessToken());

    // Get the PayPal order ID from the request (token)
    $orderId = $request->get('token');

    // Log the incoming token and order ID for debugging
    \Log::info('PayPal Success Token: ' . $orderId);

    // Execute the payment after approval
    try {
        $order = $paypal->capturePaymentOrder($orderId);

        // Log the full PayPal order response for debugging
        \Log::info('PayPal Capture Payment Order Response: ', $order);

        if ($order['status'] === 'COMPLETED') {
            // Payment completed, process the order
            $cart = Session::get('cart', []);
            $totalAmount = 0;

            // Calculate total order amount based on cart items
            foreach ($cart as $id => $item) {
                $product = Product::find($id);
                if ($product) {
                    if ($product->discount) {
                        $discountedPrice = $product->price - ($product->price * ($product->discount / 100));
                        $totalAmount += $discountedPrice * $item['quantity'];
                    } else {
                        $totalAmount += $product->price * $item['quantity'];
                    }

                    // Deduct the stock after payment is completed
                    if ($product->stock >= $item['quantity']) {
                        // Reduce the stock of the product by the quantity purchased
                        $product->stock -= $item['quantity'];
                        $product->save();
                        \Log::info("Stock Deducted for Product ID: {$product->id}, Quantity: {$item['quantity']}, New Stock: {$product->stock}");
                    } else {
                        // If stock is not sufficient, cancel the payment and show an error
                        \Log::error("Insufficient stock for Product ID: {$product->id}. Available: {$product->stock}, Requested: {$item['quantity']}");
                        return redirect()->route('checkout')->with('error', 'Insufficient stock for some items. Payment was not processed.');
                    }
                }
            }

            // Assuming the PayPal response contains shipping details, extract them
            $shippingAddress = $order['purchase_units'][0]['shipping']['address'];
            $customerName = $shippingAddress['full_name'] ?? 'Guest';
            $customerEmail = $request->get('email') ?? auth()->user()->email;  // Assuming email was passed with checkout form

            // Log the calculated total amount and customer details
            \Log::info('Total Amount: ' . $totalAmount);
            \Log::info('Customer Name: ' . $customerName);
            \Log::info('Customer Email: ' . $customerEmail);

            // Create the order record in the database
            $newOrder = Order::create([
                'user_id' => auth()->id(),  // Ensure the user is authenticated
                'total_amount' => $totalAmount,
                'payment_method' => 'PayPal',
                'shipping_address' => json_encode($shippingAddress),  // Store the shipping address as JSON
                'customer_name' => $customerName,
                'customer_email' => $customerEmail,
                'payment_status' => 'completed',  // Mark as completed after successful payment
                'shipping_status' => 'pending',  // Shipping status will be updated by admin
                'product_details' => json_encode($cart),  // Store cart contents as JSON
            ]);

            // Log the order details after saving
            \Log::info('Order Created: ', $newOrder->toArray());

            // Clear the cart after successful payment
            Session::forget('cart');

            return redirect()->route('products.index')->with('success', 'Payment successful! Your order has been placed.');
        }

        // If payment is not successful, log the error and return to checkout
        \Log::error('PayPal Payment Failed: ' . $order['status']);
        return redirect()->route('checkout')->with('error', 'Payment failed or was canceled.');
    } catch (\Exception $e) {
        // Log the exception message if something goes wrong
        \Log::error('PayPal Payment Error: ' . $e->getMessage());
        return redirect()->route('checkout')->with('error', 'An error occurred while processing your payment.');
    }
}

    // PayPal Cancel Handling
    public function paypalCancel()
    {
        return redirect()->route('checkout')->with('error', 'Payment was canceled.');
    }
}
