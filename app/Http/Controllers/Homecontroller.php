<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all products
        $products = Product::all();

        // Pass products to the 'admin.home' view
        return view('admin.home', compact('products'));
    }
}
