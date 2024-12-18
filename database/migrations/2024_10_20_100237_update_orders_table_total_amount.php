<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTableTotalAmount extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make total_amount nullable or set a default value
            $table->decimal('total_amount', 8, 2)->nullable()->default(0)->change();
            // Or just make it nullable without default
            // $table->decimal('total_amount', 8, 2)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert changes if necessary
            $table->decimal('total_amount', 8, 2)->nullable(false)->change();
        });
    }
}