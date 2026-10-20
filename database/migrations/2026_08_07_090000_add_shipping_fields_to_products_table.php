<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'weight_lbs')) $table->decimal('weight_lbs', 6, 2)->nullable();
            if (! Schema::hasColumn('products', 'length_in')) $table->decimal('length_in', 6, 2)->nullable();
            if (! Schema::hasColumn('products', 'width_in')) $table->decimal('width_in', 6, 2)->nullable();
            if (! Schema::hasColumn('products', 'height_in')) $table->decimal('height_in', 6, 2)->nullable();
            if (! Schema::hasColumn('products', 'shipping_size_preset')) $table->string('shipping_size_preset')->nullable();
        });
    }

    public function down(): void
    {
        $columns = ['weight_lbs', 'length_in', 'width_in', 'height_in', 'shipping_size_preset'];
        foreach ($columns as $column) {
            if (Schema::hasColumn('products', $column)) Schema::table('products', fn (Blueprint $table) => $table->dropColumn($column));
        }
    }
};
