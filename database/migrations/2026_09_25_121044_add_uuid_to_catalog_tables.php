<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /** Tables whose staff URLs switch from sequential ids to uuids (see App\Models\Concerns\HasPublicUuid). */
    private const TABLES = ['tours', 'destinations', 'experiences'];

    public function up(): void
    {
        foreach (self::TABLES as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->uuid('uuid')->nullable()->after('id');
            });

            DB::table($name)->whereNull('uuid')->orderBy('id')->each(function (object $row) use ($name): void {
                DB::table($name)->where('id', $row->id)->update(['uuid' => (string) Str::uuid7()]);
            });

            Schema::table($name, function (Blueprint $table) {
                $table->uuid('uuid')->nullable(false)->change();
            });

            Schema::table($name, function (Blueprint $table) {
                $table->unique('uuid');
            });
        }
    }

    public function down(): void
    {
        foreach (self::TABLES as $name) {
            Schema::table($name, function (Blueprint $table) {
                $table->dropUnique(['uuid']);
                $table->dropColumn('uuid');
            });
        }
    }
};
