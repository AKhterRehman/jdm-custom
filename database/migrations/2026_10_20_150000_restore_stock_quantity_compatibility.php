<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'stock_quantity')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedInteger('stock_quantity')->default(0);
            });
            DB::statement('UPDATE products SET stock_quantity = available_stock_quantity');
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'stock_quantity')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('stock_quantity');
            });
        }
    }
};
