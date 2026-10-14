<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->decimal('fine_amount', 10, 2)->default(0)->after('returned_at');
            $table->boolean('fine_paid')->default(false)->after('fine_amount');
        });
    }

    public function down(): void
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropColumn(['fine_amount', 'fine_paid']);
        });
    }
};