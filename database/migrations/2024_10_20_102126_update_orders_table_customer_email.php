<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTableCustomerEmail extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make customer_email nullable or set a default value if needed
            $table->string('customer_email')->nullable()->default('')->change();
            // Or just make it nullable without default:
            // $table->string('customer_email')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert changes if necessary
            $table->string('customer_email')->nullable(false)->change();
        });
    }
}
