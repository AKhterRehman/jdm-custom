<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('weight_lbs', 6, 2)->nullable()->after('stock_quantity');
            $table->decimal('length_in', 6, 2)->nullable()->after('weight_lbs');
            $table->decimal('width_in', 6, 2)->nullable()->after('length_in');
            $table->decimal('height_in', 6, 2)->nullable()->after('width_in');
            $table->string('shipping_size_preset')->nullable()->after('height_in');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['weight_lbs', 'length_in', 'width_in', 'height_in', 'shipping_size_preset']);
        });
    }
};
