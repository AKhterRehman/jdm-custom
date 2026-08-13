<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('carrier')->nullable()->after('shipping_amount');
            $table->string('service_level')->nullable()->after('carrier');
            $table->string('shippo_shipment_id')->nullable()->after('service_level');
            $table->string('shippo_rate_id')->nullable()->after('shippo_shipment_id');
            $table->string('shippo_transaction_id')->nullable()->after('shippo_rate_id');
            $table->string('tracking_number')->nullable()->after('shippo_transaction_id');
            $table->string('tracking_url')->nullable()->after('tracking_number');
            $table->string('label_url')->nullable()->after('tracking_url');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'carrier', 'service_level', 'shippo_shipment_id', 'shippo_rate_id',
                'shippo_transaction_id', 'tracking_number', 'tracking_url', 'label_url',
            ]);
        });
    }
};
