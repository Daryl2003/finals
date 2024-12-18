<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',           // Foreign key linking to users
        'total_amount',      // Total amount for the order
        'payment_method',    // Payment method used for the order
        'shipping_address',   // Shipping address for the order
        'customer_name',     // Customer's name
        'customer_email',    // Customer's email
        'payment_status',     // Status of the payment (e.g., Pending, Completed)
        'shipping_status',    // Status of the shipping (e.g., Pending, Shipped, Delivered)
        'product_details',     // Details of products in the order (can be JSON)
    ];

  
public function products()
{
    return $this->belongsToMany(Product::class, 'order_product')
                ->withPivot('quantity', 'price'); // Including quantity and price in the pivot table
}




        public function getProductDetailsAttribute($value)
        {
            return json_decode($value, true);
        }

}