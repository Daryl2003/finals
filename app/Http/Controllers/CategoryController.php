<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        // Retrieve all main categories (parent_id is null)
        $categories = Category::with('subcategories')->get();

        // Pass categories to the view
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        // Fetch all categories that are main categories (i.e., categories with no parent)
        $categories = Category::whereNull('parent_id')->get();
    
        return view('admin.categories.create', compact('categories'));
    }
    

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required|string|max:255|unique:categories,name',
        'is_subcategory' => 'required|boolean',
        'parent_category' => 'nullable|exists:categories,id', // Only validate if it's a subcategory
    ]);

    // Create category logic
    $category = new Category();
    $category->name = $request->name;

    // If it's a subcategory, set the parent category
    if ($request->is_subcategory == 1) {
        $category->parent_id = $request->parent_category;
    }

    $category->save();

    return redirect()->route('categories.index')
                     ->with('success', 'Category created successfully.');
    }

    

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, $id)
{
    // Validate the updated data
    $request->validate([
        'main_category' => 'required|string|max:255',
        'sub_category' => 'nullable|string|max:255',
    ]);

    // Find the category by ID
    $category = Category::findOrFail($id);

    // Update the category fields
    $category->main_category = $request->main_category;
    $category->sub_category = $request->sub_category;

    // Save the updated category
    $category->save();

    return redirect()->route('categories.index')
                     ->with('success', 'Category updated successfully.');
}

public function destroy($id)
{
    // Find the category by its ID
    $category = Category::findOrFail($id);

    // Delete the category
    $category->delete();

    // Redirect back to the categories index with a success message
    return redirect()->route('categories.index')
                     ->with('success', 'Category deleted successfully.');
}

}