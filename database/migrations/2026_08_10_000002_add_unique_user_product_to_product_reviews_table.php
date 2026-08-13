<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $exists = collect(Schema::getIndexes('product_reviews'))
            ->contains(fn ($index) => $index['name'] === 'product_reviews_user_id_product_id_unique');

        if ($exists) {
            return;
        }

        Schema::table('product_reviews', function (Blueprint $table) {
            $table->unique(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::table('product_reviews', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'product_id']);
        });
    }
};
