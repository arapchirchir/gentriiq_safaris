<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Non-guessable identifier for staff URLs (/staff/inquiries/{uuid}).
     * Separate from `token`, which is the guest's secret plan link and must not appear in admin URLs.
     */
    public function up(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->uuid('uuid')->nullable()->after('id');
        });

        DB::table('inquiries')->whereNull('uuid')->orderBy('id')->each(function (object $inquiry): void {
            DB::table('inquiries')->where('id', $inquiry->id)->update(['uuid' => (string) Str::uuid7()]);
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->uuid('uuid')->nullable(false)->change();
        });

        Schema::table('inquiries', function (Blueprint $table) {
            $table->unique('uuid');
        });
    }

    public function down(): void
    {
        Schema::table('inquiries', function (Blueprint $table) {
            $table->dropUnique(['uuid']);
            $table->dropColumn('uuid');
        });
    }
};
