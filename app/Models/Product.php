<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'stock',
        'image_path', // Change this if you're using a different field name for images
        'discount',
        'category_id' // Ensure category_id is fillable
    ];

    // Define the relationship with the Category model
    public function category()
    {
        return $this->belongsTo(Category::class); // Each product belongs to one category
    }

    // Optional: if you want to retrieve the main category if this is a subcategory
    public function parentCategory()
    {
        return $this->category->parent; // If the product's category has a parent (main category)
    }
}
