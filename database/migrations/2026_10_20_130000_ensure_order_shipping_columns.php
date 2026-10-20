<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'carrier')) $table->string('carrier')->nullable();
            if (! Schema::hasColumn('orders', 'service_level')) $table->string('service_level')->nullable();
            if (! Schema::hasColumn('orders', 'shippo_shipment_id')) $table->string('shippo_shipment_id')->nullable();
            if (! Schema::hasColumn('orders', 'shippo_rate_id')) $table->string('shippo_rate_id')->nullable();
            if (! Schema::hasColumn('orders', 'shippo_transaction_id')) $table->string('shippo_transaction_id')->nullable();
            if (! Schema::hasColumn('orders', 'tracking_number')) $table->string('tracking_number')->nullable();
            if (! Schema::hasColumn('orders', 'tracking_url')) $table->string('tracking_url')->nullable();
            if (! Schema::hasColumn('orders', 'label_url')) $table->string('label_url')->nullable();
        });
    }

    public function down(): void
    {
        // Keep this repair migration non-destructive. The original Shippo migration
        // owns removal of these columns when it is rolled back.
    }
};
