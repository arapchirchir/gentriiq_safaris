<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->foreignId('tour_id')->nullable()->after('token')->constrained('tours')->nullOnDelete();
            $table->foreignId('destination_id')->nullable()->after('tour_id')->constrained('destinations')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropForeign(['tour_id']);
            $table->dropForeign(['destination_id']);
            $table->dropColumn(['tour_id', 'destination_id']);
        });
    }
};
