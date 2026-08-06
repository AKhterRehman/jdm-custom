<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $columns = [
        'preferred_contact_method',
        'order_number',
        'budget_range',
        'timeline',
    ];

    public function up(): void
    {
        $existingColumns = array_filter($this->columns, fn (string $column) => Schema::hasColumn('contact_messages', $column));

        if ($existingColumns !== []) {
            Schema::table('contact_messages', function (Blueprint $table) use ($existingColumns) {
                $table->dropColumn($existingColumns);
            });
        }
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('preferred_contact_method', 20)->nullable()->after('inquiry_type');
            $table->string('order_number', 100)->nullable()->after('preferred_contact_method');
            $table->string('budget_range', 50)->nullable()->after('order_number');
            $table->string('timeline', 50)->nullable()->after('budget_range');
        });
    }
};
