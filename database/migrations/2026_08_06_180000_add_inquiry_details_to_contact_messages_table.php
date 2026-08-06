<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('email');
            $table->string('company_name')->nullable()->after('phone');
            $table->string('inquiry_type')->nullable()->after('subject');
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'company_name',
                'inquiry_type',
            ]);
        });
    }
};
