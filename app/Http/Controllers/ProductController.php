<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{
    // Display all products with sorting
    public function index(Request $request)
{
    // Retrieve sorting parameters from the request
    $sortField = $request->get('sort', 'product_name'); // Default to sorting by product name
    $sortOrder = $request->get('order', 'asc'); // Default to ascending order

    // Map sorting options to actual database columns
    $sortOptions = [
        'name_asc' => ['product_name', 'asc'],
        'name_desc' => ['product_name', 'desc'],
        'price_low_high' => ['price', 'asc'],
        'price_high_low' => ['price', 'desc'],
        'discount' => ['discount', 'desc'], // Highest discount first
    ];

    // Check if the sort field exists in our options, otherwise, use a default
    $sort = $sortOptions[$sortField] ?? ['product_name', 'asc'];

    // Get selected category ID from the request
    $categoryId = $request->get('category');

    // Start building the query for products
    $query = Product::with('category'); // Eager load the category relationship

    // If a category is selected, filter products by category
    if ($categoryId) {
        $query->where('category_id', $categoryId);
    }

    // Apply sorting
    $products = $query->orderBy($sort[0], $sort[1])
                      ->paginate(12); // Paginate the results

    // Pass sorting and filtering parameters to the view
    return view('products.index', [
        'products' => $products,
        'sortField' => $sortField,
        'sortOrder' => $sortOrder,
        'categories' => Category::all(), // Pass all categories for the filter dropdown
    ]);
}


    // Show form to create a new product
    public function create()
{
    // Fetch all categories to display in the dropdown
    $categories = Category::all();
    
    return view('products.create', compact('categories'));
}


    // Store a newly created product in the database
    public function store(Request $request)
{
    // Validate the product data
    $request->validate([
        'product_name' => 'required|string|max:255',
        'price' => 'required|numeric',
        'stock' => 'required|integer',
        'category_id' => 'required|exists:categories,id', // Validate category
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Image validation
    ]);

    // Handle the image upload
    $imagePath = null;
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public'); // Store the image
    }

    // Create the product and associate it with the selected category
    Product::create([
        'product_name' => $request->product_name,
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
        'image_path' => $imagePath, // Store the image path if it's uploaded
        'discount' => $request->discount,
        'category_id' => $request->category_id, // Store category_id
    ]);

    return redirect()->route('products.index')
                     ->with('success', 'Product created successfully.');
}


    // Show details of a specific product
    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }

    // Show form to edit a specific product
    public function edit(Product $product): View
    {
        return view('products.edit', compact('product'));
    }

    // Update the product details in the database
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'discount' => 'nullable|numeric|min:0|max:100', // Validate discount input
        ]);

        // Update product details
        $product->product_name = $request->input('product_name');
        $product->description = $request->input('description');
        $product->price = $request->input('price'); // Ensure price is set correctly
        $product->stock = $request->input('stock');

        // Handle image update
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($product->image_path && Storage::exists('public/' . $product->image_path)) {
                Storage::delete('public/' . $product->image_path);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $product->image_path = $imagePath; // Update to match your column name
        }

        // Update discount if provided
        if ($request->has('discount')) {
            $product->discount = $request->discount; // Save discount to product
        }

        // Save changes to the product
        $product->save();

        return redirect()->route('home')->with('success', 'Product updated successfully!');
    }

    // Delete a product from the database
    public function destroy(Product $product): RedirectResponse
    {
        if ($product->image_path && Storage::exists('public/' . $product->image_path)) {
            Storage::delete('public/' . $product->image_path);
        }

        $product->delete();

        return redirect()->route('home')->with('success', 'Product deleted successfully!');
    }

    // Handle product purchase (if applicable)
    public function buy($id): RedirectResponse
    {
        // Fetch the product by ID
        $product = Product::find($id);

        if ($product) {
            if ($product->stock > 0) {
                // Deduct one item from stock and save changes
                $product->stock -= 1;
                $product->save();

                return redirect()->route('products.index')->with('success', 'Product purchased successfully!');
            } else {
                return redirect()->route('products.index')->with('error', 'Product is out of stock.');
            }
        }

        return redirect()->route('products.index')->with('error', 'Product not found.');
    }
}