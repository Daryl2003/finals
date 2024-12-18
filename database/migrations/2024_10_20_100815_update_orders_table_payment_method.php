<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTablePaymentMethod extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Make payment_method nullable or set a default value if needed
            $table->string('payment_method')->nullable()->default('credit_card')->change();
            // Or just make it nullable without default:
            // $table->string('payment_method')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Revert changes if necessary
            $table->string('payment_method')->nullable(false)->change();
        });
    }
}