<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTableCustomerName extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make customer_name nullable or set a default value if needed
            $table->string('customer_name')->nullable()->default('')->change();
            // Or just make it nullable without default:
            // $table->string('customer_name')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert changes if necessary
            $table->string('customer_name')->nullable(false)->change();
        });
    }
}
