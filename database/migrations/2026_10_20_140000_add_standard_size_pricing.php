<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'uses_standard_size_pricing')) {
            Schema::table('products', function (Blueprint $table) {
                $table->boolean('uses_standard_size_pricing')->default(false)->after('is_featured');
            });
        }

        if (! Schema::hasColumn('product_variations', 'price')) {
            Schema::table('product_variations', function (Blueprint $table) {
                $table->decimal('price', 10, 2)->nullable()->after('price_adjustment');
            });
        }

    }

    public function down(): void
    {
        if (Schema::hasColumn('product_variations', 'price')) {
            Schema::table('product_variations', fn (Blueprint $table) => $table->dropColumn('price'));
        }
        if (Schema::hasColumn('products', 'uses_standard_size_pricing')) {
            Schema::table('products', fn (Blueprint $table) => $table->dropColumn('uses_standard_size_pricing'));
        }
    }
};
