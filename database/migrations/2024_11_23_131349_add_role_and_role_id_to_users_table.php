<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('role')->nullable()->after('email');
        $table->unsignedBigInteger('role_id')->nullable()->after('role');
    });

    // Optionally update existing users to have default roles
    \DB::table('users')->whereNull('role')->update(['role' => 'Customer', 'role_id' => 2]);
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop the role_id and role columns if rollback
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'role']);
        });
    }
};
