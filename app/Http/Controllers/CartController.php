<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Add a product to the cart
    public function add(Request $request, $id)
    {
        // Prevent admin users from adding products to the cart
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('products.index')->with('error', 'Admins cannot add products to the cart.');
        }

        $product = Product::find($id);

        if (!$product || $product->stock <= 0) {
            return redirect()->route('products.index')->with('error', 'Product not found or out of stock.');
        }

        // Get the requested quantity, default to 1 if not provided
        $quantity = $request->input('quantity', 1);

        // Initialize or retrieve cart from session
        $cart = Session::get('cart', []);
        
        // Calculate the discounted price if applicable
        $discountedPrice = $product->discount 
            ? $product->price - ($product->price * ($product->discount / 100)) 
            : $product->price;

        // If product is already in cart, add the quantity
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            // Add new product to cart with the specified quantity
            $cart[$id] = [
                'name' => $product->product_name,
                'price' => $discountedPrice,
                'original_price' => $product->price,
                'quantity' => $quantity, // Use the quantity from form input
                'discount' => $product->discount
            ];
        }

        // Save the updated cart to the session
        Session::put('cart', $cart);

        return redirect()->route('products.index')->with('success', 'Product added to cart!');
    }

    // View the cart
    public function view()
    {
        $cart = Session::get('cart', []);
        return view('cart.view', compact('cart'));
    }

    // Remove a product from the cart
    public function remove($id)
    {
        $cart = session()->get('cart');

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->route('cart.view')->with('success', 'Product removed from cart successfully!');
        }

        return redirect()->route('cart.view')->with('error', 'Product not found in cart.');
    }
}
