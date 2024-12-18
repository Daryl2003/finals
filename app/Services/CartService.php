<?php
namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService {
    public function addToCart($productId, $quantity, $price) {
        $cart = Session::get('cart', []);
        $cart[$productId] = [
            'quantity' => $quantity,
            'price' => $price,
        ];
        Session::put('cart', $cart);
    }

    public function getCart() {
        return Session::get('cart', []);
    }

    public function updateCart($productId, $quantity) {
        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            Session::put('cart', $cart);
        }
    }

    public function removeFromCart($productId) {
        $cart = Session::get('cart', []);
        unset($cart[$productId]);
        Session::put('cart', $cart);
    }
}