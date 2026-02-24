<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->date('dob')->nullable()->after('phone');
            $table->string('gender')->nullable()->after('dob');
            $table->string('pincode')->nullable()->after('gender');
            $table->string('city')->nullable()->after('pincode');
            $table->string('state')->nullable()->after('city');
            $table->text('address')->nullable()->after('state');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['dob', 'gender', 'pincode', 'city', 'state', 'address']);
        });
    }
};
