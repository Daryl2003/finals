<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Add new columns for payment and shipping status
            $table->string('payment_status')->default('Pending')->after('customer_email'); // Payment status
            $table->string('shipping_status')->default('Pending')->after('payment_status'); // Shipping status
            
            // Add a new column for storing product details
            $table->text('product_details')->nullable()->after('shipping_status'); // JSON or text field to store product names, quantities, and prices
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the columns if rolling back
            $table->dropColumn(['payment_status', 'shipping_status', 'product_details']);
        });
    }
}