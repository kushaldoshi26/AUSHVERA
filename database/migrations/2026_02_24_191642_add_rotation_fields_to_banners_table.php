<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->integer('rotation_time')->default(5)->comment('Seconds to display banner');
            $table->dateTime('start_date')->nullable()->comment('Banner start date');
            $table->dateTime('end_date')->nullable()->comment('Banner end date');
            $table->integer('click_count')->default(0)->comment('Track banner clicks');
            $table->integer('view_count')->default(0)->comment('Track banner views');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['rotation_time', 'start_date', 'end_date', 'click_count', 'view_count']);
        });
    }
};
