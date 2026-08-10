<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('product_reviews', 'image_path')) {
            return;
        }

        DB::statement('ALTER TABLE product_reviews MODIFY image_path TEXT NULL');
    }

    public function down(): void
    {
        if (! Schema::hasColumn('product_reviews', 'image_path')) {
            return;
        }

        DB::statement('ALTER TABLE product_reviews MODIFY image_path VARCHAR(255) NULL');
    }
};
