<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'total_stock_quantity')) {
            Schema::table('products', function (Blueprint $table) {
                $table->unsignedInteger('total_stock_quantity')->default(0);
                $table->unsignedInteger('available_stock_quantity')->default(0);
            });
        }

        if (Schema::hasColumn('products', 'stock_quantity')) {
            DB::table('products')->update([
                'total_stock_quantity' => DB::raw('stock_quantity'),
                'available_stock_quantity' => DB::raw('stock_quantity'),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['total_stock_quantity', 'available_stock_quantity']);
        });
    }
};
