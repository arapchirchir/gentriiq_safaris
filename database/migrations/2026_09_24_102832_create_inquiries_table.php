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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('reference')->unique();
            $table->uuid('token')->unique()->index();
            $table->string('trip_type'); // safari, mountain_trek, beach_holiday, bush_beach_combined
            $table->string('traveller_type'); // solo, partner, family, group
            $table->unsignedInteger('adults_count')->default(2);
            $table->unsignedInteger('children_count')->default(0);
            $table->string('travel_year');
            $table->string('travel_month');
            $table->string('travel_season')->nullable();
            $table->string('duration'); // 2-3_days, 4-6_days, 7-9_days, 10plus_days
            $table->string('accommodation_tier')->nullable(); // comfort, luxury, signature_luxury
            $table->string('budget_range')->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('country')->nullable();
            $table->text('special_requests')->nullable();
            $table->string('status')->default('new')->index(); // new, contacted, quote_sent, confirmed, cancelled
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
