<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToProductsTable extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('category_id')
                  ->nullable() // Allow products without categories initially
                  ->constrained('categories') // Links to the `categories` table
                  ->cascadeOnDelete(); // Deletes products if the category is deleted
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']); // Drops the foreign key constraint
            $table->dropColumn('category_id'); // Removes the `category_id` column
        });
    }
}
