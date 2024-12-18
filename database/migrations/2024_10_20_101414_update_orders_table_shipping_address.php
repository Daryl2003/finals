<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTableShippingAddress extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make shipping_address nullable or set a default value if needed
            $table->string('shipping_address')->nullable()->default('')->change();
            // Or just make it nullable without default:
            // $table->string('shipping_address')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert changes if necessary
            $table->string('shipping_address')->nullable(false)->change();
        });
    }
}