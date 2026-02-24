<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('category')->nullable()->after('stock');
            $table->decimal('original_price', 10, 2)->nullable()->after('price');
            $table->integer('discount')->nullable()->after('original_price');
            $table->text('display_images')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['category', 'original_price', 'discount', 'display_images']);
        });
    }
};
