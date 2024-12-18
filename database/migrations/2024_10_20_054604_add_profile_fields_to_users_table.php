<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
            $table->date('birthday')->nullable();
            $table->string('address')->nullable();
            $table->string('gender')->nullable();
            $table->integer('age')->nullable(); // Optional if you want to calculate age based on birthday
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone_number', 'birthday', 'gender', 'age', 'address']);
        });
    }
}