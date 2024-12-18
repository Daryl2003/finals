<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'parent_id'];

    // Relationship for subcategories (self-referencing)
   // In Category model
public function parent()
{
    return $this->belongsTo(Category::class, 'parent_id');
}

public function subcategories()
{
    return $this->hasMany(Category::class, 'parent_id');
}

}
